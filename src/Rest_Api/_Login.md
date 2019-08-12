## Authentication [POST]
### To Retrieve bearer token /wp-json/auth/v1/login
1. token = base 64 encoded string `user:pass`
2. header = Authorization : Basic %token%
#### Keys
1. user_id = int - matching user id
2. token = String - token to be use with subsequent requests
3. expires = String - date the token will expire

### Make authenticated requests %any url% e.g. /wp-json/wp/v2/posts/1
1. token = provided from retrieving bearer token
2. header = _Authorization : Bearer %token%_
#### Keys
1. Will return full objects like normal
