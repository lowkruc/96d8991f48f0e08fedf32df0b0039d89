## Simple PHP Rest API Sending Email with NSQ Queue 
This repo was created for **Code Challenge Levart Software Engineer** by **Ahmad Saekoni**, this project was built using several tack stacks, such as **PHP v8.2**, **Composer**, **PostgreSQL**, **NSQ** , **JWT**, **SMTP Email**.

_Note: sorry in this project i don't use OAUTH2 and i use JWT, i need more time to build with requirment_

### Swimline Design System
![Swimlime Design System](https://raw.githubusercontent.com/lowkruc/96d8991f48f0e08fedf32df0b0039d89/main/swimline.png)

### Feature
- User registration.
- User login to get JWT token.
- Sending email with NSQ queue.
- Store email message to postgresql.

### Technologies Used
- **PHP v8**
- **Composer**
- **JWT**
- **PostgreSQL**
- **NSQ**
- **SMTP Email**
- **Docker**


### Prerequisites 
Before you begin, ensure you have met the following requirements: 
- PHP and Composer installed, make sure php is version 8++.
- Docker installed and running
- NSQ Server installed and running.
- A SMPT Server

### Installation
Before installation, make sure **PHP**, **Composer** and **Docker** is running well, and **NSQ Server**, and **SMTPServer** is ready to use.

1. Clone this reposity
	```bash
	git clone https://github.com/lowkruc/96d8991f48f0e08fedf32df0b0039d89.git ./php-send-email
	cd php-send-email
	```
2. Add .env file to root dir
	```bash
	db_host=postgres
	db_port=5432
	db_name=levart_blastemail
	db_username=postgres
	db_password=postgres

	smtp_host=smtp-relay.brevo.com
	smtp_port=587
	smtp_username=772cbe001@smtp-brevo.com
	smtp_password=HMm724j6PaKsYvyI
	smtp_sender_email=asemediatech@gmail.com
	smtp_sender_name="Ahmad Saekoni"

	nsq_host=nsq-service.asemedia.tech #without http or https
	nsq_port=4150
	nsq_topic_mailer=worker_mailer
	nsq_channel_mailer_consumer=php_mailer_handler
	```
3. Composer Install
	```bash
	composer install
	```
4.  Run rest api
	```bash
	sudo docker compose up # if you want to rebuild image, add --build
	```
5. Test API
	```bash
	curl --location --request GET '127.0.0.1:8080/ping'
	```

## API Endpoint
### Health Check
- URL: ```127.0.0.1:8080/ping```
- Method: ```GET```
- Authorization: ```false```
- Response
	```json
	{
		"status": "ok",
		"online": true,
		"date": "2024-06-23 13:21:16"
	}
	```
	
### Register
- URL: ```127.0.0.1:8080/register```
- Method: ```POST```
- Authorization: ```false```
- Request Body
	```json
	{
		"name": "xxxx",
		"username": "xxxx",
		"password": "xxxx",
	}
	```
- Response
	```json
	{
		"status": "ok"
	}
	```
	
### Get Access Token
- URL: ```127.0.0.1:8080/auth```
- Method: ```POST```
- Authorization: ```false```
- Request Body
	```json
	{
		"username": "xxxx",
		"password": "xxxx",
	}
	```
- Response
	```json
	{
		"status": true,
		"access_token": "xxxxxxx",
	}
	```

### Send Email
- URL: ```127.0.0.1:8080/email```
- Method: ```POST```
- Authorization: ```true```
- Request Body
	```json
	{ 
		"recipient": "asemediatech@gmail.com",
		"subject": "xxxx",
		"body": "xxxx" 
	}
	```
- Response
	```json
	{
		"status": "ok",
	}
	```
