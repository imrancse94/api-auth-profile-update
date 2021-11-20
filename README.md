### Project Setup

1. git clone https://github.com/imrancse94/api-auth-profile-update.git

2. composer install

3. copy .env.example to .env change db credentials, smtp info

4. php artisan jwt:secret 
   php artisan config:cache
   php artisan migrate
   php artisan db:seed (For one admin dummy insertion)

5. php artisan serve and php artisan queue:work (For email sending)

6. Import postman collection from project root. (Assesment.postman_collection.json)

### Tests

## Here all apis content-type = application/json, Accept = application/json

1. Login
curl --location --request POST 'http://127.0.0.1:8000/api/login' \
--header 'Content-Type: application/json' \
--header 'Accept: application/json' \
--data-raw '{
    "user_name":"imrancse93",
    "password":"123456"
}'

2. Invitation
After getting access token put it on Authorization header
curl --location --request POST 'http://127.0.0.1:8000/api/invite/user/' \
--header 'Authorization: Bearer <--access_token-->' \
--header 'Accept: application/json' \
--header 'Content-Type: application/json' \
--form 'email="<--any_user_email-->"'

3. User Register (create username and password)
From email copy the link and do like below
curl --location --request POST 'http://127.0.0.1:8000/api/user/register/plXnqH9HwzTtN9lXZd0G3' \
--header 'Accept: application/json' \
--header 'Content-Type: application/json' \
--form 'user_name="<--any_user_name-->"' \
--form 'password="<--any_password-->"'

4. Confirmation (for 6 digits confirmation code)
curl --location --request POST 'http://127.0.0.1:8000/api/user/confirmation/plXnqH9HwzTtN9lXZd0G3' \
--header 'Accept: application/json' \
--header 'Content-Type: application/json' \
--form 'pin="<--pin_from_email-->"'

5. Profile Update 
Login again by the new user and profile update.
curl --location --request POST 'http://127.0.0.1:8000/api/user/profile/update' \
--header 'Authorization: Bearer <--access_token-->' \
--header 'Accept: application/json' \
--header 'Content-Type: application/json' \
--form 'name="Kabir Ahmed"' \
--form 'avatar=@"<--avatar_file_path-->"'
