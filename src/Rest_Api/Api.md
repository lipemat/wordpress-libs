## Using WP REST API conventions for as much as possible http://v2.wp-api.org/reference/posts/ . This documents custom args and keys only. The rest is available per the standard docs

## To enable

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


## Posts [GET]

### Post Endpoint /wp-json/wp/v2/posts
#### Keys
1. meta = {} - list of (public) post meta by key
2. terms = [] - list of all terms and their data per all support taxonomies
3. thumbnail = String - url of featured image
4. content.stripped = String - content stripped of all tags

## Taxonomies [GET]

### List Terms Endpoint /wp-json/taxonomies/v1/terms/{taxonomy}
#### Args
1. taxonomy = string - taxonomy to get terms for (passed via url)

#### Keys
1. terms = [] - list of all terms and their data per all support taxonomies
