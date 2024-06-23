<?php
/**
 * EmailBlast\App Namespace
 * This namespace contains classes specific to the EmailBlast Rest API.
 *
 * PHP version 8.2
 *
 * @category Namespace
 * @package  EmailBlast\App
 * @author   Ahmad Saekoni <asemediatech@gmail.com>
 * @license  http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link     https://github.com/lowkruc/96d8991f48f0e08fedf32df0b0039d89
 */

namespace EmailBlast\App;

use PDO;
use PDOException;
use Exception;

/**
 * Database Class
 * This Class for handling connection to PostgreSQL Database
 *
 * @category Class
 * @package  EmailBlast\App\Database
 * @author   Ahmad Saekoni <asemediatech@gmail.com>
 * @license  http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link     https://github.com/lowkruc/96d8991f48f0e08fedf32df0b0039d89
 */
class Database
{
    protected PDO $conn;
    protected string $table;
    protected array $select = ['*'];
    protected array $where = [];
    protected array $orderBy = [];
    protected int $limit;
    protected int $offset;
    protected array $bindings = [];

    /**
     * Constructor Database
     *
     * This function connects to the database
     *
     * @return void
     */
    public function __construct()
    {
        $dsn = sprintf(
            "pgsql:host=%s;port=%s;dbname=%s",
            $_ENV["db_host"],
            $_ENV["db_port"],
            $_ENV["db_name"]
        );

        $options = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ];

        try {
            $this->conn = new PDO(
                $dsn,
                $_ENV['db_username'],
                $_ENV['db_password'],
                $options
            );
        } catch (PDOException $e) {
            throw new Exception($e->getMessage());
        }
    }

    /**
     * Select Table
     *
     * @param string $table The table name.
     *
     * @return self
     */
    public function table(string $table): self
    {
        $this->table = $table;
        return $this;
    }

    /**
     * Select Columns
     *
     * @param array $columns The columns to select.
     *
     * @return self
     */
    public function select(array $columns): self
    {
        $this->select = $columns;
        return $this;
    }

    /**
     * Where Condition
     *
     * @param string $column   The column name.
     * @param string $operator The operator.
     * @param mixed  $value    The value.
     *
     * @return self
     */
    public function where(string $column, string $operator, $value): self
    {
        $this->where[] = [$column, $operator, $value];
        $this->bindings[$column] = $value;
        return $this;
    }

    /**
     * Order By
     *
     * @param string $column    The column name.
     * @param string $direction The direction (ASC or DESC).
     *
     * @return self
     */
    public function orderBy(string $column, string $direction = 'ASC'): self
    {
        $this->orderBy[] = [$column, $direction];
        return $this;
    }

    /**
     * Limit
     *
     * @param int $limit The limit.
     *
     * @return self
     */
    public function limit(int $limit): self
    {
        $this->limit = $limit;
        return $this;
    }

    /**
     * Offset
     *
     * @param int $offset The offset.
     *
     * @return self
     */
    public function offset(int $offset): self
    {
        $this->offset = $offset;
        return $this;
    }

    /**
     * Insert Data
     *
     * @param array $data The data to insert.
     *
     * @return bool
     */
    public function insert(array $data): bool
    {
        $columns = implode(', ', array_keys($data));
        $placeholders = ':' . implode(', :', array_keys($data));
        $query = "INSERT INTO {$this->table} ($columns) VALUES ($placeholders)";

        $result = $this->_executeStatement($query, $data);
        if ($result instanceof \PDOStatement) {
            return $result->rowCount() > 0;
        }
        return $result;
    }

    /**
     * Update Data
     *
     * @param array $data The data to update.
     *
     * @return bool
     */
    public function update(array $data): bool
    {
        $set = implode(
            ', ',
            array_map(fn($key) => "$key = :$key", array_keys($data))
        );
        $query = "UPDATE {$this->table} SET $set " . $this->buildWhereClause();

        $result = $this->_executeStatement($query, array_merge($data, $this->bindings));
        if ($result instanceof \PDOStatement) {
            return $result->rowCount() > 0;
        }
        return $result;
    }

    /**
     * Delete Data
     *
     * @return bool
     */
    public function delete(): bool
    {
        $query = "DELETE FROM {$this->table} " . $this->buildWhereClause();

        $result = $this->_executeStatement($query, $this->bindings);
        if ($result instanceof \PDOStatement) {
            return $result->rowCount() > 0;
        }
        return $result;
    }

    /**
     * Get Single Record
     *
     * @return array
     */
    public function first(): array
    {
        $this->limit(1);
        $query = $this->buildSelectQuery();
        return $this->fetchAll($query, $this->bindings)[0] ?? [];
    }

    /**
     * Get All Records
     *
     * @return array
     */
    public function get(): array
    {
        $query = $this->buildSelectQuery();
        return $this->fetchAll($query, $this->bindings);
    }

    /**
     * Build Select Query
     *
     * @return string
     */
    protected function buildSelectQuery(): string
    {
        $select = implode(', ', $this->select);
        $query = "SELECT $select FROM {$this->table}";

        $query .= $this->buildWhereClause();

        if (!empty($this->orderBy)) {
            $orderByClauses = array_map(fn($o) => "{$o[0]} {$o[1]}", $this->orderBy);
            $query .= ' ORDER BY ' . implode(', ', $orderByClauses);
        }

        if (isset($this->limit)) {
            $query .= " LIMIT {$this->limit}";
        }

        if (isset($this->offset)) {
            $query .= " OFFSET {$this->offset}";
        }

        return $query;
    }

    /**
     * Build Where Clause
     *
     * @return string
     */
    protected function buildWhereClause(): string
    {
        if (empty($this->where)) {
            return '';
        }

        $whereClauses = array_map(
            fn($w) => "{$w[0]} {$w[1]} :{$w[0]}",
            $this->where
        );
        return ' WHERE ' . implode(' AND ', $whereClauses);
    }

    /**
     * Execute Statement
     * This function executes a statement and binds parameters
     *
     * @param string $query  The raw SQL query.
     * @param array  $params Parameters to bind to the query.
     *
     * @return bool
     */
    private function _executeStatement(string $query, array $params = []): bool|\PDOStatement
    {
        try {
            $stmt = $this->conn->prepare($query);
            foreach ($params as $key => &$val) {
                $stmt->bindParam(":$key", $val);
            }
            $stmt->execute();
            return $stmt;
        } catch (PDOException $e) {
            throw new Exception($e->getMessage());
        }
    }

    /**
     * Fetch All Records
     * This function executes a select query to get all results
     *
     * @param string $query  The raw SQL query.
     * @param array  $params Parameters to bind to the query.
     *
     * @return array
     */
    public function fetchAll(string $query, array $params = []): array
    {
        $stmt = $this->_executeStatement($query, $params);
        return $stmt->fetchAll();
    }
}
