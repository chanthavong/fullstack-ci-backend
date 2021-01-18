Ci HMVC rest APIs

use 
CodeIgniter Rest Server
https://github.com/chriskacerguis/codeigniter-restserver

CodeIgniter Rest Server With JWT Authentication
https://github.com/dodistyo/ci-rest-jwt

# Exampl for CodeIgniter Backend REST API 

url  run project
http://localhost/ci-hmvc-rest-api-jwt/api/v1/

or

http://localhost/ci-hmvc-rest-api-jwt/index.php/api/v1/


edit routes controllers to
/Application/modules/api/controllers/v1/welcome.php

# HMVC

# Feature
- JWT
- User Auth
- Example model

email: mark@gmail.com
pwd: 12345678

#Example header 
http://localhost/ci-hmvc-rest-api-jwt/index.php/api/v1/profile (get method http)
{
	"Authorization": "Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpZCI6IjEiLCJlbWFpbCI6Im1hcmtAZ21haWwuY29tIiwiZnVsbG5hbWUiOiJNYXJrIn0.4mTzrVuTJzyXKUij1gu_yhOlyoppJPOb-gAEfVJGtlw"
}

(Not a complate)
