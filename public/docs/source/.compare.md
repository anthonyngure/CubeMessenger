---
title: API Reference

language_tabs:
- bash
- javascript

includes:

search: true

toc_footers:
- <a href='http://github.com/mpociot/documentarian'>Documentation Powered by Documentarian</a>
---
<!-- START_INFO -->
# Info

Welcome to the generated API reference.
[Get Postman Collection](http://localhost:8000/docs/collection.json)

<!-- END_INFO -->

#general
<!-- START_2eefa0e787b59fafed2c72988dc86226 -->
## api/v1/auth/signIn

> Example request:

```bash
curl -X POST "http://localhost:8000/api/v1/auth/signIn" \
-H "Accept: application/json"
```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://localhost:8000/api/v1/auth/signIn",
    "method": "POST",
    "headers": {
        "accept": "application/json"
    }
}

$.ajax(settings).done(function (response) {
    console.log(response);
});
```


### HTTP Request
`POST api/v1/auth/signIn`


<!-- END_2eefa0e787b59fafed2c72988dc86226 -->

<!-- START_2031314e6df1fa0e948c9cb09e26c807 -->
## Display a listing of the resource.

> Example request:

```bash
curl -X GET "http://localhost:8000/api/v1/courierOptions" \
-H "Accept: application/json"
```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://localhost:8000/api/v1/courierOptions",
    "method": "GET",
    "headers": {
        "accept": "application/json"
    }
}

$.ajax(settings).done(function (response) {
    console.log(response);
});
```

> Example response:

```json
{
    "meta": {
        "message": "Unauthenticated.",
        "code": "UNAUTHORIZED"
    },
    "data": []
}
```

### HTTP Request
`GET api/v1/courierOptions`

`HEAD api/v1/courierOptions`


<!-- END_2031314e6df1fa0e948c9cb09e26c807 -->

<!-- START_d36a068044a3977d6f0d740163f8f1fe -->
## Show the form for creating a new resource.

> Example request:

```bash
curl -X GET "http://localhost:8000/api/v1/courierOptions/create" \
-H "Accept: application/json"
```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://localhost:8000/api/v1/courierOptions/create",
    "method": "GET",
    "headers": {
        "accept": "application/json"
    }
}

$.ajax(settings).done(function (response) {
    console.log(response);
});
```

> Example response:

```json
{
    "meta": {
        "message": "Unauthenticated.",
        "code": "UNAUTHORIZED"
    },
    "data": []
}
```

### HTTP Request
`GET api/v1/courierOptions/create`

`HEAD api/v1/courierOptions/create`


<!-- END_d36a068044a3977d6f0d740163f8f1fe -->

<!-- START_4ab61c3171b46d14eeb663a0f7cf1622 -->
## Store a newly created resource in storage.

> Example request:

```bash
curl -X POST "http://localhost:8000/api/v1/courierOptions" \
-H "Accept: application/json"
```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://localhost:8000/api/v1/courierOptions",
    "method": "POST",
    "headers": {
        "accept": "application/json"
    }
}

$.ajax(settings).done(function (response) {
    console.log(response);
});
```


### HTTP Request
`POST api/v1/courierOptions`


<!-- END_4ab61c3171b46d14eeb663a0f7cf1622 -->

<!-- START_4ae97dcd25694189dac3d8e07514c3e8 -->
## Display the specified resource.

> Example request:

```bash
curl -X GET "http://localhost:8000/api/v1/courierOptions/{courierOption}" \
-H "Accept: application/json"
```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://localhost:8000/api/v1/courierOptions/{courierOption}",
    "method": "GET",
    "headers": {
        "accept": "application/json"
    }
}

$.ajax(settings).done(function (response) {
    console.log(response);
});
```

> Example response:

```json
{
    "meta": {
        "message": "Unauthenticated.",
        "code": "UNAUTHORIZED"
    },
    "data": []
}
```

### HTTP Request
`GET api/v1/courierOptions/{courierOption}`

`HEAD api/v1/courierOptions/{courierOption}`


<!-- END_4ae97dcd25694189dac3d8e07514c3e8 -->

<!-- START_d4979288445e5e8620bae2df6f0dfdf3 -->
## Show the form for editing the specified resource.

> Example request:

```bash
curl -X GET "http://localhost:8000/api/v1/courierOptions/{courierOption}/edit" \
-H "Accept: application/json"
```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://localhost:8000/api/v1/courierOptions/{courierOption}/edit",
    "method": "GET",
    "headers": {
        "accept": "application/json"
    }
}

$.ajax(settings).done(function (response) {
    console.log(response);
});
```

> Example response:

```json
{
    "meta": {
        "message": "Unauthenticated.",
        "code": "UNAUTHORIZED"
    },
    "data": []
}
```

### HTTP Request
`GET api/v1/courierOptions/{courierOption}/edit`

`HEAD api/v1/courierOptions/{courierOption}/edit`


<!-- END_d4979288445e5e8620bae2df6f0dfdf3 -->

<!-- START_53f1c3b5ee746027d341588e612227f4 -->
## Update the specified resource in storage.

> Example request:

```bash
curl -X PUT "http://localhost:8000/api/v1/courierOptions/{courierOption}" \
-H "Accept: application/json"
```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://localhost:8000/api/v1/courierOptions/{courierOption}",
    "method": "PUT",
    "headers": {
        "accept": "application/json"
    }
}

$.ajax(settings).done(function (response) {
    console.log(response);
});
```


### HTTP Request
`PUT api/v1/courierOptions/{courierOption}`

`PATCH api/v1/courierOptions/{courierOption}`


<!-- END_53f1c3b5ee746027d341588e612227f4 -->

<!-- START_088fa6f07d0ae655aeea6b26ea3f55cc -->
## Remove the specified resource from storage.

> Example request:

```bash
curl -X DELETE "http://localhost:8000/api/v1/courierOptions/{courierOption}" \
-H "Accept: application/json"
```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://localhost:8000/api/v1/courierOptions/{courierOption}",
    "method": "DELETE",
    "headers": {
        "accept": "application/json"
    }
}

$.ajax(settings).done(function (response) {
    console.log(response);
});
```


### HTTP Request
`DELETE api/v1/courierOptions/{courierOption}`


<!-- END_088fa6f07d0ae655aeea6b26ea3f55cc -->

<!-- START_c592c810c8094dad18210d757efc925c -->
## api/v1/auth/signOut

> Example request:

```bash
curl -X POST "http://localhost:8000/api/v1/auth/signOut" \
-H "Accept: application/json"
```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://localhost:8000/api/v1/auth/signOut",
    "method": "POST",
    "headers": {
        "accept": "application/json"
    }
}

$.ajax(settings).done(function (response) {
    console.log(response);
});
```


### HTTP Request
`POST api/v1/auth/signOut`


<!-- END_c592c810c8094dad18210d757efc925c -->

<!-- START_29ad049b182baa84aefd2c96650b36c5 -->
## api/v1/auth/refresh

> Example request:

```bash
curl -X GET "http://localhost:8000/api/v1/auth/refresh" \
-H "Accept: application/json"
```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://localhost:8000/api/v1/auth/refresh",
    "method": "GET",
    "headers": {
        "accept": "application/json"
    }
}

$.ajax(settings).done(function (response) {
    console.log(response);
});
```

> Example response:

```json
{
    "meta": {
        "message": "Unauthenticated.",
        "code": "UNAUTHORIZED"
    },
    "data": []
}
```

### HTTP Request
`GET api/v1/auth/refresh`

`HEAD api/v1/auth/refresh`


<!-- END_29ad049b182baa84aefd2c96650b36c5 -->

<!-- START_2844064d57cef80772662abf1c7f58fb -->
## api/v1/auth

> Example request:

```bash
curl -X GET "http://localhost:8000/api/v1/auth" \
-H "Accept: application/json"
```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://localhost:8000/api/v1/auth",
    "method": "GET",
    "headers": {
        "accept": "application/json"
    }
}

$.ajax(settings).done(function (response) {
    console.log(response);
});
```

> Example response:

```json
{
    "meta": {
        "message": "Unauthenticated.",
        "code": "UNAUTHORIZED"
    },
    "data": []
}
```

### HTTP Request
`GET api/v1/auth`

`HEAD api/v1/auth`


<!-- END_2844064d57cef80772662abf1c7f58fb -->

<!-- START_8068864cee912582439ebbdb5f1a7dab -->
## api/v1/drawerItems

> Example request:

```bash
curl -X GET "http://localhost:8000/api/v1/drawerItems" \
-H "Accept: application/json"
```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://localhost:8000/api/v1/drawerItems",
    "method": "GET",
    "headers": {
        "accept": "application/json"
    }
}

$.ajax(settings).done(function (response) {
    console.log(response);
});
```

> Example response:

```json
{
    "meta": {
        "message": "Unauthenticated.",
        "code": "UNAUTHORIZED"
    },
    "data": []
}
```

### HTTP Request
`GET api/v1/drawerItems`

`HEAD api/v1/drawerItems`


<!-- END_8068864cee912582439ebbdb5f1a7dab -->

<!-- START_5fd1d3c95e9a04c70813eda7c1b33698 -->
## api/v1/balance

> Example request:

```bash
curl -X GET "http://localhost:8000/api/v1/balance" \
-H "Accept: application/json"
```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://localhost:8000/api/v1/balance",
    "method": "GET",
    "headers": {
        "accept": "application/json"
    }
}

$.ajax(settings).done(function (response) {
    console.log(response);
});
```

> Example response:

```json
{
    "meta": {
        "message": "Unauthenticated.",
        "code": "UNAUTHORIZED"
    },
    "data": []
}
```

### HTTP Request
`GET api/v1/balance`

`HEAD api/v1/balance`


<!-- END_5fd1d3c95e9a04c70813eda7c1b33698 -->

<!-- START_f7102ec8d4ace832763c16126afb1ac7 -->
## api/v1/user/appointments

> Example request:

```bash
curl -X GET "http://localhost:8000/api/v1/user/appointments" \
-H "Accept: application/json"
```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://localhost:8000/api/v1/user/appointments",
    "method": "GET",
    "headers": {
        "accept": "application/json"
    }
}

$.ajax(settings).done(function (response) {
    console.log(response);
});
```

> Example response:

```json
{
    "meta": {
        "message": "Unauthenticated.",
        "code": "UNAUTHORIZED"
    },
    "data": []
}
```

### HTTP Request
`GET api/v1/user/appointments`

`HEAD api/v1/user/appointments`


<!-- END_f7102ec8d4ace832763c16126afb1ac7 -->

<!-- START_4c120abbcf1899ab3b9d1a4885016fd0 -->
## api/v1/user/changePassword

> Example request:

```bash
curl -X POST "http://localhost:8000/api/v1/user/changePassword" \
-H "Accept: application/json"
```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://localhost:8000/api/v1/user/changePassword",
    "method": "POST",
    "headers": {
        "accept": "application/json"
    }
}

$.ajax(settings).done(function (response) {
    console.log(response);
});
```


### HTTP Request
`POST api/v1/user/changePassword`


<!-- END_4c120abbcf1899ab3b9d1a4885016fd0 -->

<!-- START_080f3ecebb7bcc2f93284b8f5ae1ac3b -->
## Display a listing of the resource.

> Example request:

```bash
curl -X GET "http://localhost:8000/api/v1/users" \
-H "Accept: application/json"
```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://localhost:8000/api/v1/users",
    "method": "GET",
    "headers": {
        "accept": "application/json"
    }
}

$.ajax(settings).done(function (response) {
    console.log(response);
});
```

> Example response:

```json
{
    "meta": {
        "message": "Unauthenticated.",
        "code": "UNAUTHORIZED"
    },
    "data": []
}
```

### HTTP Request
`GET api/v1/users`

`HEAD api/v1/users`


<!-- END_080f3ecebb7bcc2f93284b8f5ae1ac3b -->

<!-- START_4194ceb9a20b7f80b61d14d44df366b4 -->
## Store a newly created resource in storage.

> Example request:

```bash
curl -X POST "http://localhost:8000/api/v1/users" \
-H "Accept: application/json"
```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://localhost:8000/api/v1/users",
    "method": "POST",
    "headers": {
        "accept": "application/json"
    }
}

$.ajax(settings).done(function (response) {
    console.log(response);
});
```


### HTTP Request
`POST api/v1/users`


<!-- END_4194ceb9a20b7f80b61d14d44df366b4 -->

<!-- START_b4ea58dd963da91362c51d4088d0d4f4 -->
## Display the specified resource.

> Example request:

```bash
curl -X GET "http://localhost:8000/api/v1/users/{user}" \
-H "Accept: application/json"
```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://localhost:8000/api/v1/users/{user}",
    "method": "GET",
    "headers": {
        "accept": "application/json"
    }
}

$.ajax(settings).done(function (response) {
    console.log(response);
});
```

> Example response:

```json
{
    "meta": {
        "message": "Unauthenticated.",
        "code": "UNAUTHORIZED"
    },
    "data": []
}
```

### HTTP Request
`GET api/v1/users/{user}`

`HEAD api/v1/users/{user}`


<!-- END_b4ea58dd963da91362c51d4088d0d4f4 -->

<!-- START_296fac4bf818c99f6dd42a4a0eb56b58 -->
## Update the specified resource in storage.

> Example request:

```bash
curl -X PUT "http://localhost:8000/api/v1/users/{user}" \
-H "Accept: application/json"
```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://localhost:8000/api/v1/users/{user}",
    "method": "PUT",
    "headers": {
        "accept": "application/json"
    }
}

$.ajax(settings).done(function (response) {
    console.log(response);
});
```


### HTTP Request
`PUT api/v1/users/{user}`

`PATCH api/v1/users/{user}`


<!-- END_296fac4bf818c99f6dd42a4a0eb56b58 -->

<!-- START_22354fc95c42d81a744eece68f5b9b9a -->
## Remove the specified resource from storage.

> Example request:

```bash
curl -X DELETE "http://localhost:8000/api/v1/users/{user}" \
-H "Accept: application/json"
```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://localhost:8000/api/v1/users/{user}",
    "method": "DELETE",
    "headers": {
        "accept": "application/json"
    }
}

$.ajax(settings).done(function (response) {
    console.log(response);
});
```


### HTTP Request
`DELETE api/v1/users/{user}`


<!-- END_22354fc95c42d81a744eece68f5b9b9a -->

<!-- START_071b36460784d2b3117f8dc8ed9f8035 -->
## api/v1/clients/search

> Example request:

```bash
curl -X GET "http://localhost:8000/api/v1/clients/search" \
-H "Accept: application/json"
```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://localhost:8000/api/v1/clients/search",
    "method": "GET",
    "headers": {
        "accept": "application/json"
    }
}

$.ajax(settings).done(function (response) {
    console.log(response);
});
```

> Example response:

```json
{
    "meta": {
        "message": "Unauthenticated.",
        "code": "UNAUTHORIZED"
    },
    "data": []
}
```

### HTTP Request
`GET api/v1/clients/search`

`HEAD api/v1/clients/search`


<!-- END_071b36460784d2b3117f8dc8ed9f8035 -->

<!-- START_7e9f5b1587d0c719b038488a542b7da1 -->
## Display a listing of the resource.

> Example request:

```bash
curl -X GET "http://localhost:8000/api/v1/clients" \
-H "Accept: application/json"
```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://localhost:8000/api/v1/clients",
    "method": "GET",
    "headers": {
        "accept": "application/json"
    }
}

$.ajax(settings).done(function (response) {
    console.log(response);
});
```

> Example response:

```json
{
    "meta": {
        "message": "Unauthenticated.",
        "code": "UNAUTHORIZED"
    },
    "data": []
}
```

### HTTP Request
`GET api/v1/clients`

`HEAD api/v1/clients`


<!-- END_7e9f5b1587d0c719b038488a542b7da1 -->

<!-- START_ea5d45fea2067cf017070eef3c0a218a -->
## Store a newly created resource in storage.

> Example request:

```bash
curl -X POST "http://localhost:8000/api/v1/clients" \
-H "Accept: application/json"
```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://localhost:8000/api/v1/clients",
    "method": "POST",
    "headers": {
        "accept": "application/json"
    }
}

$.ajax(settings).done(function (response) {
    console.log(response);
});
```


### HTTP Request
`POST api/v1/clients`


<!-- END_ea5d45fea2067cf017070eef3c0a218a -->

<!-- START_a712717120a9bcce1484e57903aa6e00 -->
## Display the specified resource.

> Example request:

```bash
curl -X GET "http://localhost:8000/api/v1/clients/{client}" \
-H "Accept: application/json"
```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://localhost:8000/api/v1/clients/{client}",
    "method": "GET",
    "headers": {
        "accept": "application/json"
    }
}

$.ajax(settings).done(function (response) {
    console.log(response);
});
```

> Example response:

```json
{
    "meta": {
        "message": "Unauthenticated.",
        "code": "UNAUTHORIZED"
    },
    "data": []
}
```

### HTTP Request
`GET api/v1/clients/{client}`

`HEAD api/v1/clients/{client}`


<!-- END_a712717120a9bcce1484e57903aa6e00 -->

<!-- START_a2f5d404b22778510ba03d1f69fc2995 -->
## Update the specified resource in storage.

> Example request:

```bash
curl -X PUT "http://localhost:8000/api/v1/clients/{client}" \
-H "Accept: application/json"
```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://localhost:8000/api/v1/clients/{client}",
    "method": "PUT",
    "headers": {
        "accept": "application/json"
    }
}

$.ajax(settings).done(function (response) {
    console.log(response);
});
```


### HTTP Request
`PUT api/v1/clients/{client}`

`PATCH api/v1/clients/{client}`


<!-- END_a2f5d404b22778510ba03d1f69fc2995 -->

<!-- START_a459ae691097b563ccfa0d03a96bb9c0 -->
## Remove the specified resource from storage.

> Example request:

```bash
curl -X DELETE "http://localhost:8000/api/v1/clients/{client}" \
-H "Accept: application/json"
```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://localhost:8000/api/v1/clients/{client}",
    "method": "DELETE",
    "headers": {
        "accept": "application/json"
    }
}

$.ajax(settings).done(function (response) {
    console.log(response);
});
```


### HTTP Request
`DELETE api/v1/clients/{client}`


<!-- END_a459ae691097b563ccfa0d03a96bb9c0 -->

<!-- START_742a1a4c8d17ebb1444773cc57c10f4c -->
## Display a listing of the resource.

> Example request:

```bash
curl -X GET "http://localhost:8000/api/v1/topUps" \
-H "Accept: application/json"
```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://localhost:8000/api/v1/topUps",
    "method": "GET",
    "headers": {
        "accept": "application/json"
    }
}

$.ajax(settings).done(function (response) {
    console.log(response);
});
```

> Example response:

```json
{
    "meta": {
        "message": "Unauthenticated.",
        "code": "UNAUTHORIZED"
    },
    "data": []
}
```

### HTTP Request
`GET api/v1/topUps`

`HEAD api/v1/topUps`


<!-- END_742a1a4c8d17ebb1444773cc57c10f4c -->

<!-- START_930aac7efe9fde13fcd98c804f4ef988 -->
## Store a newly created resource in storage.

> Example request:

```bash
curl -X POST "http://localhost:8000/api/v1/topUps" \
-H "Accept: application/json"
```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://localhost:8000/api/v1/topUps",
    "method": "POST",
    "headers": {
        "accept": "application/json"
    }
}

$.ajax(settings).done(function (response) {
    console.log(response);
});
```


### HTTP Request
`POST api/v1/topUps`


<!-- END_930aac7efe9fde13fcd98c804f4ef988 -->

<!-- START_537926e93a93732a1726577e3ec3b1eb -->
## Display the specified resource.

> Example request:

```bash
curl -X GET "http://localhost:8000/api/v1/topUps/{topUp}" \
-H "Accept: application/json"
```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://localhost:8000/api/v1/topUps/{topUp}",
    "method": "GET",
    "headers": {
        "accept": "application/json"
    }
}

$.ajax(settings).done(function (response) {
    console.log(response);
});
```

> Example response:

```json
{
    "meta": {
        "message": "Unauthenticated.",
        "code": "UNAUTHORIZED"
    },
    "data": []
}
```

### HTTP Request
`GET api/v1/topUps/{topUp}`

`HEAD api/v1/topUps/{topUp}`


<!-- END_537926e93a93732a1726577e3ec3b1eb -->

<!-- START_562d27a23445d8e209138cbfd654b1a5 -->
## Update the specified resource in storage.

> Example request:

```bash
curl -X PUT "http://localhost:8000/api/v1/topUps/{topUp}" \
-H "Accept: application/json"
```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://localhost:8000/api/v1/topUps/{topUp}",
    "method": "PUT",
    "headers": {
        "accept": "application/json"
    }
}

$.ajax(settings).done(function (response) {
    console.log(response);
});
```


### HTTP Request
`PUT api/v1/topUps/{topUp}`

`PATCH api/v1/topUps/{topUp}`


<!-- END_562d27a23445d8e209138cbfd654b1a5 -->

<!-- START_f0b0c0e9527c29e0423ea48d74f7a470 -->
## Remove the specified resource from storage.

> Example request:

```bash
curl -X DELETE "http://localhost:8000/api/v1/topUps/{topUp}" \
-H "Accept: application/json"
```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://localhost:8000/api/v1/topUps/{topUp}",
    "method": "DELETE",
    "headers": {
        "accept": "application/json"
    }
}

$.ajax(settings).done(function (response) {
    console.log(response);
});
```


### HTTP Request
`DELETE api/v1/topUps/{topUp}`


<!-- END_f0b0c0e9527c29e0423ea48d74f7a470 -->

<!-- START_1d1d007961b8cb854b4886d45436f988 -->
## Display a listing of the resource.

> Example request:

```bash
curl -X GET "http://localhost:8000/api/v1/departments" \
-H "Accept: application/json"
```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://localhost:8000/api/v1/departments",
    "method": "GET",
    "headers": {
        "accept": "application/json"
    }
}

$.ajax(settings).done(function (response) {
    console.log(response);
});
```

> Example response:

```json
{
    "meta": {
        "message": "Unauthenticated.",
        "code": "UNAUTHORIZED"
    },
    "data": []
}
```

### HTTP Request
`GET api/v1/departments`

`HEAD api/v1/departments`


<!-- END_1d1d007961b8cb854b4886d45436f988 -->

<!-- START_906e9f05fc0e3e67e494de5216c04690 -->
## Store a newly created resource in storage.

> Example request:

```bash
curl -X POST "http://localhost:8000/api/v1/departments" \
-H "Accept: application/json"
```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://localhost:8000/api/v1/departments",
    "method": "POST",
    "headers": {
        "accept": "application/json"
    }
}

$.ajax(settings).done(function (response) {
    console.log(response);
});
```


### HTTP Request
`POST api/v1/departments`


<!-- END_906e9f05fc0e3e67e494de5216c04690 -->

<!-- START_c378864792ae8ead8dd366c729bae0f2 -->
## Display the specified resource.

> Example request:

```bash
curl -X GET "http://localhost:8000/api/v1/departments/{department}" \
-H "Accept: application/json"
```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://localhost:8000/api/v1/departments/{department}",
    "method": "GET",
    "headers": {
        "accept": "application/json"
    }
}

$.ajax(settings).done(function (response) {
    console.log(response);
});
```

> Example response:

```json
{
    "meta": {
        "message": "Unauthenticated.",
        "code": "UNAUTHORIZED"
    },
    "data": []
}
```

### HTTP Request
`GET api/v1/departments/{department}`

`HEAD api/v1/departments/{department}`


<!-- END_c378864792ae8ead8dd366c729bae0f2 -->

<!-- START_accd9957963adc58a7fe94bac55bf7b5 -->
## Update the specified resource in storage.

> Example request:

```bash
curl -X PUT "http://localhost:8000/api/v1/departments/{department}" \
-H "Accept: application/json"
```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://localhost:8000/api/v1/departments/{department}",
    "method": "PUT",
    "headers": {
        "accept": "application/json"
    }
}

$.ajax(settings).done(function (response) {
    console.log(response);
});
```


### HTTP Request
`PUT api/v1/departments/{department}`

`PATCH api/v1/departments/{department}`


<!-- END_accd9957963adc58a7fe94bac55bf7b5 -->

<!-- START_9b6e8ce529e300ec3bd3f2b26d57143d -->
## Remove the specified resource from storage.

> Example request:

```bash
curl -X DELETE "http://localhost:8000/api/v1/departments/{department}" \
-H "Accept: application/json"
```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://localhost:8000/api/v1/departments/{department}",
    "method": "DELETE",
    "headers": {
        "accept": "application/json"
    }
}

$.ajax(settings).done(function (response) {
    console.log(response);
});
```


### HTTP Request
`DELETE api/v1/departments/{department}`


<!-- END_9b6e8ce529e300ec3bd3f2b26d57143d -->

<!-- START_e2fbc9e729cbb60570545bad72e6caee -->
## Display a listing of the resource.

> Example request:

```bash
curl -X GET "http://localhost:8000/api/v1/deliveries" \
-H "Accept: application/json"
```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://localhost:8000/api/v1/deliveries",
    "method": "GET",
    "headers": {
        "accept": "application/json"
    }
}

$.ajax(settings).done(function (response) {
    console.log(response);
});
```

> Example response:

```json
{
    "meta": {
        "message": "Unauthenticated.",
        "code": "UNAUTHORIZED"
    },
    "data": []
}
```

### HTTP Request
`GET api/v1/deliveries`

`HEAD api/v1/deliveries`


<!-- END_e2fbc9e729cbb60570545bad72e6caee -->

<!-- START_a214a5436e50c55e48d6a259b8373c7a -->
## Store a newly created resource in storage.

> Example request:

```bash
curl -X POST "http://localhost:8000/api/v1/deliveries" \
-H "Accept: application/json"
```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://localhost:8000/api/v1/deliveries",
    "method": "POST",
    "headers": {
        "accept": "application/json"
    }
}

$.ajax(settings).done(function (response) {
    console.log(response);
});
```


### HTTP Request
`POST api/v1/deliveries`


<!-- END_a214a5436e50c55e48d6a259b8373c7a -->

<!-- START_553cce60328bc331dab8d80426682aaa -->
## Display the specified resource.

> Example request:

```bash
curl -X GET "http://localhost:8000/api/v1/deliveries/{delivery}" \
-H "Accept: application/json"
```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://localhost:8000/api/v1/deliveries/{delivery}",
    "method": "GET",
    "headers": {
        "accept": "application/json"
    }
}

$.ajax(settings).done(function (response) {
    console.log(response);
});
```

> Example response:

```json
{
    "meta": {
        "message": "Unauthenticated.",
        "code": "UNAUTHORIZED"
    },
    "data": []
}
```

### HTTP Request
`GET api/v1/deliveries/{delivery}`

`HEAD api/v1/deliveries/{delivery}`


<!-- END_553cce60328bc331dab8d80426682aaa -->

<!-- START_e54c0e187a4d3df108edcd172ea5728d -->
## Update the specified resource in storage.

> Example request:

```bash
curl -X PUT "http://localhost:8000/api/v1/deliveries/{delivery}" \
-H "Accept: application/json"
```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://localhost:8000/api/v1/deliveries/{delivery}",
    "method": "PUT",
    "headers": {
        "accept": "application/json"
    }
}

$.ajax(settings).done(function (response) {
    console.log(response);
});
```


### HTTP Request
`PUT api/v1/deliveries/{delivery}`

`PATCH api/v1/deliveries/{delivery}`


<!-- END_e54c0e187a4d3df108edcd172ea5728d -->

<!-- START_1e379d000123f0654e5f7f57c67474c4 -->
## Remove the specified resource from storage.

> Example request:

```bash
curl -X DELETE "http://localhost:8000/api/v1/deliveries/{delivery}" \
-H "Accept: application/json"
```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://localhost:8000/api/v1/deliveries/{delivery}",
    "method": "DELETE",
    "headers": {
        "accept": "application/json"
    }
}

$.ajax(settings).done(function (response) {
    console.log(response);
});
```


### HTTP Request
`DELETE api/v1/deliveries/{delivery}`


<!-- END_1e379d000123f0654e5f7f57c67474c4 -->

<!-- START_f2f2ee39be2c0eaac1d513ffd1a5818c -->
## Display a listing of the resource.

> Example request:

```bash
curl -X GET "http://localhost:8000/api/v1/deliveries/{delivery}/items" \
-H "Accept: application/json"
```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://localhost:8000/api/v1/deliveries/{delivery}/items",
    "method": "GET",
    "headers": {
        "accept": "application/json"
    }
}

$.ajax(settings).done(function (response) {
    console.log(response);
});
```

> Example response:

```json
{
    "meta": {
        "message": "Unauthenticated.",
        "code": "UNAUTHORIZED"
    },
    "data": []
}
```

### HTTP Request
`GET api/v1/deliveries/{delivery}/items`

`HEAD api/v1/deliveries/{delivery}/items`


<!-- END_f2f2ee39be2c0eaac1d513ffd1a5818c -->

<!-- START_3014e717af93effbde770128f8c6f0f4 -->
## Store a newly created resource in storage.

> Example request:

```bash
curl -X POST "http://localhost:8000/api/v1/deliveries/{delivery}/items" \
-H "Accept: application/json"
```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://localhost:8000/api/v1/deliveries/{delivery}/items",
    "method": "POST",
    "headers": {
        "accept": "application/json"
    }
}

$.ajax(settings).done(function (response) {
    console.log(response);
});
```


### HTTP Request
`POST api/v1/deliveries/{delivery}/items`


<!-- END_3014e717af93effbde770128f8c6f0f4 -->

<!-- START_f7bccbd539afa463251db9be0db801c9 -->
## Display the specified resource.

> Example request:

```bash
curl -X GET "http://localhost:8000/api/v1/deliveries/{delivery}/items/{item}" \
-H "Accept: application/json"
```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://localhost:8000/api/v1/deliveries/{delivery}/items/{item}",
    "method": "GET",
    "headers": {
        "accept": "application/json"
    }
}

$.ajax(settings).done(function (response) {
    console.log(response);
});
```

> Example response:

```json
{
    "meta": {
        "message": "Unauthenticated.",
        "code": "UNAUTHORIZED"
    },
    "data": []
}
```

### HTTP Request
`GET api/v1/deliveries/{delivery}/items/{item}`

`HEAD api/v1/deliveries/{delivery}/items/{item}`


<!-- END_f7bccbd539afa463251db9be0db801c9 -->

<!-- START_28cbe09d3f54fe9acab3240d56b4d733 -->
## Update the specified resource in storage.

> Example request:

```bash
curl -X PUT "http://localhost:8000/api/v1/deliveries/{delivery}/items/{item}" \
-H "Accept: application/json"
```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://localhost:8000/api/v1/deliveries/{delivery}/items/{item}",
    "method": "PUT",
    "headers": {
        "accept": "application/json"
    }
}

$.ajax(settings).done(function (response) {
    console.log(response);
});
```


### HTTP Request
`PUT api/v1/deliveries/{delivery}/items/{item}`

`PATCH api/v1/deliveries/{delivery}/items/{item}`


<!-- END_28cbe09d3f54fe9acab3240d56b4d733 -->

<!-- START_aada97417f3e063349e5f427b5672ee4 -->
## Remove the specified resource from storage.

> Example request:

```bash
curl -X DELETE "http://localhost:8000/api/v1/deliveries/{delivery}/items/{item}" \
-H "Accept: application/json"
```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://localhost:8000/api/v1/deliveries/{delivery}/items/{item}",
    "method": "DELETE",
    "headers": {
        "accept": "application/json"
    }
}

$.ajax(settings).done(function (response) {
    console.log(response);
});
```


### HTTP Request
`DELETE api/v1/deliveries/{delivery}/items/{item}`


<!-- END_aada97417f3e063349e5f427b5672ee4 -->

<!-- START_56ef4765a66284e8eee54f748f90f87f -->
## Display a listing of the resource.

> Example request:

```bash
curl -X GET "http://localhost:8000/api/v1/subscriptionOptions" \
-H "Accept: application/json"
```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://localhost:8000/api/v1/subscriptionOptions",
    "method": "GET",
    "headers": {
        "accept": "application/json"
    }
}

$.ajax(settings).done(function (response) {
    console.log(response);
});
```

> Example response:

```json
{
    "meta": {
        "message": "Unauthenticated.",
        "code": "UNAUTHORIZED"
    },
    "data": []
}
```

### HTTP Request
`GET api/v1/subscriptionOptions`

`HEAD api/v1/subscriptionOptions`


<!-- END_56ef4765a66284e8eee54f748f90f87f -->

<!-- START_46dcd308965b0b9fd76e9440ef86abcd -->
## Display a listing of the resource.

> Example request:

```bash
curl -X GET "http://localhost:8000/api/v1/subscriptions" \
-H "Accept: application/json"
```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://localhost:8000/api/v1/subscriptions",
    "method": "GET",
    "headers": {
        "accept": "application/json"
    }
}

$.ajax(settings).done(function (response) {
    console.log(response);
});
```

> Example response:

```json
{
    "meta": {
        "message": "Unauthenticated.",
        "code": "UNAUTHORIZED"
    },
    "data": []
}
```

### HTTP Request
`GET api/v1/subscriptions`

`HEAD api/v1/subscriptions`


<!-- END_46dcd308965b0b9fd76e9440ef86abcd -->

<!-- START_57f95cc57747e1a383396274c98f7bbc -->
## Store a newly created resource in storage.

> Example request:

```bash
curl -X POST "http://localhost:8000/api/v1/subscriptions" \
-H "Accept: application/json"
```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://localhost:8000/api/v1/subscriptions",
    "method": "POST",
    "headers": {
        "accept": "application/json"
    }
}

$.ajax(settings).done(function (response) {
    console.log(response);
});
```


### HTTP Request
`POST api/v1/subscriptions`


<!-- END_57f95cc57747e1a383396274c98f7bbc -->

<!-- START_d398888f170a89ff50e3021d8f88fd18 -->
## Display the specified resource.

> Example request:

```bash
curl -X GET "http://localhost:8000/api/v1/subscriptions/{subscription}" \
-H "Accept: application/json"
```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://localhost:8000/api/v1/subscriptions/{subscription}",
    "method": "GET",
    "headers": {
        "accept": "application/json"
    }
}

$.ajax(settings).done(function (response) {
    console.log(response);
});
```

> Example response:

```json
{
    "meta": {
        "message": "Unauthenticated.",
        "code": "UNAUTHORIZED"
    },
    "data": []
}
```

### HTTP Request
`GET api/v1/subscriptions/{subscription}`

`HEAD api/v1/subscriptions/{subscription}`


<!-- END_d398888f170a89ff50e3021d8f88fd18 -->

<!-- START_e2e4e30fc64aaaf16d0f5fcbe028cd3b -->
## Update the specified resource in storage.

> Example request:

```bash
curl -X PUT "http://localhost:8000/api/v1/subscriptions/{subscription}" \
-H "Accept: application/json"
```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://localhost:8000/api/v1/subscriptions/{subscription}",
    "method": "PUT",
    "headers": {
        "accept": "application/json"
    }
}

$.ajax(settings).done(function (response) {
    console.log(response);
});
```


### HTTP Request
`PUT api/v1/subscriptions/{subscription}`

`PATCH api/v1/subscriptions/{subscription}`


<!-- END_e2e4e30fc64aaaf16d0f5fcbe028cd3b -->

<!-- START_4f80f857cf645ef568850b179668affc -->
## Remove the specified resource from storage.

> Example request:

```bash
curl -X DELETE "http://localhost:8000/api/v1/subscriptions/{subscription}" \
-H "Accept: application/json"
```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://localhost:8000/api/v1/subscriptions/{subscription}",
    "method": "DELETE",
    "headers": {
        "accept": "application/json"
    }
}

$.ajax(settings).done(function (response) {
    console.log(response);
});
```


### HTTP Request
`DELETE api/v1/subscriptions/{subscription}`


<!-- END_4f80f857cf645ef568850b179668affc -->

<!-- START_4f624d49fd0117158c0d24840d6feaba -->
## api/v1/roles/search

> Example request:

```bash
curl -X GET "http://localhost:8000/api/v1/roles/search" \
-H "Accept: application/json"
```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://localhost:8000/api/v1/roles/search",
    "method": "GET",
    "headers": {
        "accept": "application/json"
    }
}

$.ajax(settings).done(function (response) {
    console.log(response);
});
```

> Example response:

```json
{
    "meta": {
        "message": "Unauthenticated.",
        "code": "UNAUTHORIZED"
    },
    "data": []
}
```

### HTTP Request
`GET api/v1/roles/search`

`HEAD api/v1/roles/search`


<!-- END_4f624d49fd0117158c0d24840d6feaba -->

<!-- START_d97fba8dbd0d0033960fdc6a25fca8d9 -->
## Display a listing of the resource.

> Example request:

```bash
curl -X GET "http://localhost:8000/api/v1/roles" \
-H "Accept: application/json"
```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://localhost:8000/api/v1/roles",
    "method": "GET",
    "headers": {
        "accept": "application/json"
    }
}

$.ajax(settings).done(function (response) {
    console.log(response);
});
```

> Example response:

```json
{
    "meta": {
        "message": "Unauthenticated.",
        "code": "UNAUTHORIZED"
    },
    "data": []
}
```

### HTTP Request
`GET api/v1/roles`

`HEAD api/v1/roles`


<!-- END_d97fba8dbd0d0033960fdc6a25fca8d9 -->

<!-- START_5f753b2bffb6b34b6136ddfe1be7bcce -->
## Store a newly created resource in storage.

> Example request:

```bash
curl -X POST "http://localhost:8000/api/v1/roles" \
-H "Accept: application/json"
```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://localhost:8000/api/v1/roles",
    "method": "POST",
    "headers": {
        "accept": "application/json"
    }
}

$.ajax(settings).done(function (response) {
    console.log(response);
});
```


### HTTP Request
`POST api/v1/roles`


<!-- END_5f753b2bffb6b34b6136ddfe1be7bcce -->

<!-- START_f47a034257a009b731160db044157715 -->
## Display the specified resource.

> Example request:

```bash
curl -X GET "http://localhost:8000/api/v1/roles/{role}" \
-H "Accept: application/json"
```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://localhost:8000/api/v1/roles/{role}",
    "method": "GET",
    "headers": {
        "accept": "application/json"
    }
}

$.ajax(settings).done(function (response) {
    console.log(response);
});
```

> Example response:

```json
{
    "meta": {
        "message": "Unauthenticated.",
        "code": "UNAUTHORIZED"
    },
    "data": []
}
```

### HTTP Request
`GET api/v1/roles/{role}`

`HEAD api/v1/roles/{role}`


<!-- END_f47a034257a009b731160db044157715 -->

<!-- START_81ac9047f8db2b92092c5a7f13e5d28d -->
## Update the specified resource in storage.

> Example request:

```bash
curl -X PUT "http://localhost:8000/api/v1/roles/{role}" \
-H "Accept: application/json"
```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://localhost:8000/api/v1/roles/{role}",
    "method": "PUT",
    "headers": {
        "accept": "application/json"
    }
}

$.ajax(settings).done(function (response) {
    console.log(response);
});
```


### HTTP Request
`PUT api/v1/roles/{role}`

`PATCH api/v1/roles/{role}`


<!-- END_81ac9047f8db2b92092c5a7f13e5d28d -->

<!-- START_04c524fc2f0ea8c793406426144b4c71 -->
## Remove the specified resource from storage.

> Example request:

```bash
curl -X DELETE "http://localhost:8000/api/v1/roles/{role}" \
-H "Accept: application/json"
```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://localhost:8000/api/v1/roles/{role}",
    "method": "DELETE",
    "headers": {
        "accept": "application/json"
    }
}

$.ajax(settings).done(function (response) {
    console.log(response);
});
```


### HTTP Request
`DELETE api/v1/roles/{role}`


<!-- END_04c524fc2f0ea8c793406426144b4c71 -->

<!-- START_1d37adaebf939582cd2395b2716be133 -->
## api/v1/appointments/userSuggestions

> Example request:

```bash
curl -X GET "http://localhost:8000/api/v1/appointments/userSuggestions" \
-H "Accept: application/json"
```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://localhost:8000/api/v1/appointments/userSuggestions",
    "method": "GET",
    "headers": {
        "accept": "application/json"
    }
}

$.ajax(settings).done(function (response) {
    console.log(response);
});
```

> Example response:

```json
{
    "meta": {
        "message": "Unauthenticated.",
        "code": "UNAUTHORIZED"
    },
    "data": []
}
```

### HTTP Request
`GET api/v1/appointments/userSuggestions`

`HEAD api/v1/appointments/userSuggestions`


<!-- END_1d37adaebf939582cd2395b2716be133 -->

<!-- START_0f594da7ed492a8d736a67ad11d0b6e1 -->
## Display a listing of the resource.

> Example request:

```bash
curl -X GET "http://localhost:8000/api/v1/appointments" \
-H "Accept: application/json"
```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://localhost:8000/api/v1/appointments",
    "method": "GET",
    "headers": {
        "accept": "application/json"
    }
}

$.ajax(settings).done(function (response) {
    console.log(response);
});
```

> Example response:

```json
{
    "meta": {
        "message": "Unauthenticated.",
        "code": "UNAUTHORIZED"
    },
    "data": []
}
```

### HTTP Request
`GET api/v1/appointments`

`HEAD api/v1/appointments`


<!-- END_0f594da7ed492a8d736a67ad11d0b6e1 -->

<!-- START_2fb32093c962fd1839a0eb9ed3447678 -->
## Store a newly created resource in storage.

> Example request:

```bash
curl -X POST "http://localhost:8000/api/v1/appointments" \
-H "Accept: application/json"
```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://localhost:8000/api/v1/appointments",
    "method": "POST",
    "headers": {
        "accept": "application/json"
    }
}

$.ajax(settings).done(function (response) {
    console.log(response);
});
```


### HTTP Request
`POST api/v1/appointments`


<!-- END_2fb32093c962fd1839a0eb9ed3447678 -->

<!-- START_bc8b7131393bf4f523c048deeff91487 -->
## Display the specified resource.

> Example request:

```bash
curl -X GET "http://localhost:8000/api/v1/appointments/{appointment}" \
-H "Accept: application/json"
```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://localhost:8000/api/v1/appointments/{appointment}",
    "method": "GET",
    "headers": {
        "accept": "application/json"
    }
}

$.ajax(settings).done(function (response) {
    console.log(response);
});
```

> Example response:

```json
{
    "meta": {
        "message": "Unauthenticated.",
        "code": "UNAUTHORIZED"
    },
    "data": []
}
```

### HTTP Request
`GET api/v1/appointments/{appointment}`

`HEAD api/v1/appointments/{appointment}`


<!-- END_bc8b7131393bf4f523c048deeff91487 -->

<!-- START_f2866ce2c685d955245e66ec035c9a94 -->
## Update the specified resource in storage.

> Example request:

```bash
curl -X PUT "http://localhost:8000/api/v1/appointments/{appointment}" \
-H "Accept: application/json"
```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://localhost:8000/api/v1/appointments/{appointment}",
    "method": "PUT",
    "headers": {
        "accept": "application/json"
    }
}

$.ajax(settings).done(function (response) {
    console.log(response);
});
```


### HTTP Request
`PUT api/v1/appointments/{appointment}`

`PATCH api/v1/appointments/{appointment}`


<!-- END_f2866ce2c685d955245e66ec035c9a94 -->

<!-- START_4d71d63ab0627cdb684e3f9288b90c93 -->
## Remove the specified resource from storage.

> Example request:

```bash
curl -X DELETE "http://localhost:8000/api/v1/appointments/{appointment}" \
-H "Accept: application/json"
```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://localhost:8000/api/v1/appointments/{appointment}",
    "method": "DELETE",
    "headers": {
        "accept": "application/json"
    }
}

$.ajax(settings).done(function (response) {
    console.log(response);
});
```


### HTTP Request
`DELETE api/v1/appointments/{appointment}`


<!-- END_4d71d63ab0627cdb684e3f9288b90c93 -->

<!-- START_675d57da5d2df3ad3cf2459c3020ccf6 -->
## Display a listing of the resource.

> Example request:

```bash
curl -X GET "http://localhost:8000/api/v1/products" \
-H "Accept: application/json"
```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://localhost:8000/api/v1/products",
    "method": "GET",
    "headers": {
        "accept": "application/json"
    }
}

$.ajax(settings).done(function (response) {
    console.log(response);
});
```

> Example response:

```json
{
    "meta": {
        "message": "Unauthenticated.",
        "code": "UNAUTHORIZED"
    },
    "data": []
}
```

### HTTP Request
`GET api/v1/products`

`HEAD api/v1/products`


<!-- END_675d57da5d2df3ad3cf2459c3020ccf6 -->

<!-- START_c5a77561baaaf96156fa4f456281b25f -->
## Store a newly created resource in storage.

> Example request:

```bash
curl -X POST "http://localhost:8000/api/v1/products" \
-H "Accept: application/json"
```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://localhost:8000/api/v1/products",
    "method": "POST",
    "headers": {
        "accept": "application/json"
    }
}

$.ajax(settings).done(function (response) {
    console.log(response);
});
```


### HTTP Request
`POST api/v1/products`


<!-- END_c5a77561baaaf96156fa4f456281b25f -->

<!-- START_7616ac68c37e261ec5619a6d82ca8774 -->
## Display the specified resource.

> Example request:

```bash
curl -X GET "http://localhost:8000/api/v1/products/{product}" \
-H "Accept: application/json"
```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://localhost:8000/api/v1/products/{product}",
    "method": "GET",
    "headers": {
        "accept": "application/json"
    }
}

$.ajax(settings).done(function (response) {
    console.log(response);
});
```

> Example response:

```json
{
    "meta": {
        "message": "Unauthenticated.",
        "code": "UNAUTHORIZED"
    },
    "data": []
}
```

### HTTP Request
`GET api/v1/products/{product}`

`HEAD api/v1/products/{product}`


<!-- END_7616ac68c37e261ec5619a6d82ca8774 -->

<!-- START_c7a6a2912490841bc7c990bdba4945c7 -->
## Update the specified resource in storage.

> Example request:

```bash
curl -X PUT "http://localhost:8000/api/v1/products/{product}" \
-H "Accept: application/json"
```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://localhost:8000/api/v1/products/{product}",
    "method": "PUT",
    "headers": {
        "accept": "application/json"
    }
}

$.ajax(settings).done(function (response) {
    console.log(response);
});
```


### HTTP Request
`PUT api/v1/products/{product}`

`PATCH api/v1/products/{product}`


<!-- END_c7a6a2912490841bc7c990bdba4945c7 -->

<!-- START_8170e43979dbc7d681c58185ab9efbac -->
## Remove the specified resource from storage.

> Example request:

```bash
curl -X DELETE "http://localhost:8000/api/v1/products/{product}" \
-H "Accept: application/json"
```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://localhost:8000/api/v1/products/{product}",
    "method": "DELETE",
    "headers": {
        "accept": "application/json"
    }
}

$.ajax(settings).done(function (response) {
    console.log(response);
});
```


### HTTP Request
`DELETE api/v1/products/{product}`


<!-- END_8170e43979dbc7d681c58185ab9efbac -->

<!-- START_bdd3ccf7db9f96843f0bb3617eac0164 -->
## Display a listing of the resource.

> Example request:

```bash
curl -X GET "http://localhost:8000/api/v1/categories" \
-H "Accept: application/json"
```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://localhost:8000/api/v1/categories",
    "method": "GET",
    "headers": {
        "accept": "application/json"
    }
}

$.ajax(settings).done(function (response) {
    console.log(response);
});
```

> Example response:

```json
{
    "meta": {
        "message": "Unauthenticated.",
        "code": "UNAUTHORIZED"
    },
    "data": []
}
```

### HTTP Request
`GET api/v1/categories`

`HEAD api/v1/categories`


<!-- END_bdd3ccf7db9f96843f0bb3617eac0164 -->

<!-- START_51652a01dd7666395568dd6ba9d67d58 -->
## Store a newly created resource in storage.

> Example request:

```bash
curl -X POST "http://localhost:8000/api/v1/categories" \
-H "Accept: application/json"
```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://localhost:8000/api/v1/categories",
    "method": "POST",
    "headers": {
        "accept": "application/json"
    }
}

$.ajax(settings).done(function (response) {
    console.log(response);
});
```


### HTTP Request
`POST api/v1/categories`


<!-- END_51652a01dd7666395568dd6ba9d67d58 -->

<!-- START_2bd3e8cdd1330aa83f81993ffdd2dac8 -->
## Display the specified resource.

> Example request:

```bash
curl -X GET "http://localhost:8000/api/v1/categories/{category}" \
-H "Accept: application/json"
```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://localhost:8000/api/v1/categories/{category}",
    "method": "GET",
    "headers": {
        "accept": "application/json"
    }
}

$.ajax(settings).done(function (response) {
    console.log(response);
});
```

> Example response:

```json
{
    "meta": {
        "message": "Unauthenticated.",
        "code": "UNAUTHORIZED"
    },
    "data": []
}
```

### HTTP Request
`GET api/v1/categories/{category}`

`HEAD api/v1/categories/{category}`


<!-- END_2bd3e8cdd1330aa83f81993ffdd2dac8 -->

<!-- START_58b09cda1a6b4241d0b8f55289d7bd09 -->
## Update the specified resource in storage.

> Example request:

```bash
curl -X PUT "http://localhost:8000/api/v1/categories/{category}" \
-H "Accept: application/json"
```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://localhost:8000/api/v1/categories/{category}",
    "method": "PUT",
    "headers": {
        "accept": "application/json"
    }
}

$.ajax(settings).done(function (response) {
    console.log(response);
});
```


### HTTP Request
`PUT api/v1/categories/{category}`

`PATCH api/v1/categories/{category}`


<!-- END_58b09cda1a6b4241d0b8f55289d7bd09 -->

<!-- START_75b173cefee1332cf71f9d29370afde7 -->
## Remove the specified resource from storage.

> Example request:

```bash
curl -X DELETE "http://localhost:8000/api/v1/categories/{category}" \
-H "Accept: application/json"
```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://localhost:8000/api/v1/categories/{category}",
    "method": "DELETE",
    "headers": {
        "accept": "application/json"
    }
}

$.ajax(settings).done(function (response) {
    console.log(response);
});
```


### HTTP Request
`DELETE api/v1/categories/{category}`


<!-- END_75b173cefee1332cf71f9d29370afde7 -->

<!-- START_9f4416af3adf345d945a7d233c75697f -->
## Display a listing of the resource.

> Example request:

```bash
curl -X GET "http://localhost:8000/api/v1/serviceRequests" \
-H "Accept: application/json"
```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://localhost:8000/api/v1/serviceRequests",
    "method": "GET",
    "headers": {
        "accept": "application/json"
    }
}

$.ajax(settings).done(function (response) {
    console.log(response);
});
```

> Example response:

```json
{
    "meta": {
        "message": "Unauthenticated.",
        "code": "UNAUTHORIZED"
    },
    "data": []
}
```

### HTTP Request
`GET api/v1/serviceRequests`

`HEAD api/v1/serviceRequests`


<!-- END_9f4416af3adf345d945a7d233c75697f -->

<!-- START_76aeab2a0ae4b2348868c2e66f59db35 -->
## Store a newly created resource in storage.

> Example request:

```bash
curl -X POST "http://localhost:8000/api/v1/serviceRequests" \
-H "Accept: application/json"
```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://localhost:8000/api/v1/serviceRequests",
    "method": "POST",
    "headers": {
        "accept": "application/json"
    }
}

$.ajax(settings).done(function (response) {
    console.log(response);
});
```


### HTTP Request
`POST api/v1/serviceRequests`


<!-- END_76aeab2a0ae4b2348868c2e66f59db35 -->

<!-- START_8e367d139c3337bf0ba3de7ee1ffe093 -->
## Display the specified resource.

> Example request:

```bash
curl -X GET "http://localhost:8000/api/v1/serviceRequests/{serviceRequest}" \
-H "Accept: application/json"
```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://localhost:8000/api/v1/serviceRequests/{serviceRequest}",
    "method": "GET",
    "headers": {
        "accept": "application/json"
    }
}

$.ajax(settings).done(function (response) {
    console.log(response);
});
```

> Example response:

```json
{
    "meta": {
        "message": "Unauthenticated.",
        "code": "UNAUTHORIZED"
    },
    "data": []
}
```

### HTTP Request
`GET api/v1/serviceRequests/{serviceRequest}`

`HEAD api/v1/serviceRequests/{serviceRequest}`


<!-- END_8e367d139c3337bf0ba3de7ee1ffe093 -->

<!-- START_e6b874b5775177c894b40ec07519ef14 -->
## Update the specified resource in storage.

> Example request:

```bash
curl -X PUT "http://localhost:8000/api/v1/serviceRequests/{serviceRequest}" \
-H "Accept: application/json"
```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://localhost:8000/api/v1/serviceRequests/{serviceRequest}",
    "method": "PUT",
    "headers": {
        "accept": "application/json"
    }
}

$.ajax(settings).done(function (response) {
    console.log(response);
});
```


### HTTP Request
`PUT api/v1/serviceRequests/{serviceRequest}`

`PATCH api/v1/serviceRequests/{serviceRequest}`


<!-- END_e6b874b5775177c894b40ec07519ef14 -->

<!-- START_0a262014a26814d76950bb0732a786ec -->
## Remove the specified resource from storage.

> Example request:

```bash
curl -X DELETE "http://localhost:8000/api/v1/serviceRequests/{serviceRequest}" \
-H "Accept: application/json"
```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://localhost:8000/api/v1/serviceRequests/{serviceRequest}",
    "method": "DELETE",
    "headers": {
        "accept": "application/json"
    }
}

$.ajax(settings).done(function (response) {
    console.log(response);
});
```


### HTTP Request
`DELETE api/v1/serviceRequests/{serviceRequest}`


<!-- END_0a262014a26814d76950bb0732a786ec -->

<!-- START_cac955f0d56482b7e0ee515123828aca -->
## Display a listing of the resource.

> Example request:

```bash
curl -X GET "http://localhost:8000/api/v1/serviceRequestQuotes" \
-H "Accept: application/json"
```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://localhost:8000/api/v1/serviceRequestQuotes",
    "method": "GET",
    "headers": {
        "accept": "application/json"
    }
}

$.ajax(settings).done(function (response) {
    console.log(response);
});
```

> Example response:

```json
{
    "meta": {
        "message": "Unauthenticated.",
        "code": "UNAUTHORIZED"
    },
    "data": []
}
```

### HTTP Request
`GET api/v1/serviceRequestQuotes`

`HEAD api/v1/serviceRequestQuotes`


<!-- END_cac955f0d56482b7e0ee515123828aca -->

<!-- START_798727094ce5759b23510a8775a3fccd -->
## Store a newly created resource in storage.

> Example request:

```bash
curl -X POST "http://localhost:8000/api/v1/serviceRequestQuotes" \
-H "Accept: application/json"
```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://localhost:8000/api/v1/serviceRequestQuotes",
    "method": "POST",
    "headers": {
        "accept": "application/json"
    }
}

$.ajax(settings).done(function (response) {
    console.log(response);
});
```


### HTTP Request
`POST api/v1/serviceRequestQuotes`


<!-- END_798727094ce5759b23510a8775a3fccd -->

<!-- START_ed59340848c8996e039cdf12f10e531f -->
## Display the specified resource.

> Example request:

```bash
curl -X GET "http://localhost:8000/api/v1/serviceRequestQuotes/{serviceRequestQuote}" \
-H "Accept: application/json"
```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://localhost:8000/api/v1/serviceRequestQuotes/{serviceRequestQuote}",
    "method": "GET",
    "headers": {
        "accept": "application/json"
    }
}

$.ajax(settings).done(function (response) {
    console.log(response);
});
```

> Example response:

```json
{
    "meta": {
        "message": "Unauthenticated.",
        "code": "UNAUTHORIZED"
    },
    "data": []
}
```

### HTTP Request
`GET api/v1/serviceRequestQuotes/{serviceRequestQuote}`

`HEAD api/v1/serviceRequestQuotes/{serviceRequestQuote}`


<!-- END_ed59340848c8996e039cdf12f10e531f -->

<!-- START_4c50b81333647f4692b1212f501ee1a7 -->
## Update the specified resource in storage.

> Example request:

```bash
curl -X PUT "http://localhost:8000/api/v1/serviceRequestQuotes/{serviceRequestQuote}" \
-H "Accept: application/json"
```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://localhost:8000/api/v1/serviceRequestQuotes/{serviceRequestQuote}",
    "method": "PUT",
    "headers": {
        "accept": "application/json"
    }
}

$.ajax(settings).done(function (response) {
    console.log(response);
});
```


### HTTP Request
`PUT api/v1/serviceRequestQuotes/{serviceRequestQuote}`

`PATCH api/v1/serviceRequestQuotes/{serviceRequestQuote}`


<!-- END_4c50b81333647f4692b1212f501ee1a7 -->

<!-- START_3b3738c9ac6debe364477266a69e16f2 -->
## Remove the specified resource from storage.

> Example request:

```bash
curl -X DELETE "http://localhost:8000/api/v1/serviceRequestQuotes/{serviceRequestQuote}" \
-H "Accept: application/json"
```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://localhost:8000/api/v1/serviceRequestQuotes/{serviceRequestQuote}",
    "method": "DELETE",
    "headers": {
        "accept": "application/json"
    }
}

$.ajax(settings).done(function (response) {
    console.log(response);
});
```


### HTTP Request
`DELETE api/v1/serviceRequestQuotes/{serviceRequestQuote}`


<!-- END_3b3738c9ac6debe364477266a69e16f2 -->

<!-- START_f2646b0342d5943eae2fe3e181c0a698 -->
## Display a listing of the resource.

> Example request:

```bash
curl -X GET "http://localhost:8000/api/v1/serviceRequestOptions" \
-H "Accept: application/json"
```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://localhost:8000/api/v1/serviceRequestOptions",
    "method": "GET",
    "headers": {
        "accept": "application/json"
    }
}

$.ajax(settings).done(function (response) {
    console.log(response);
});
```

> Example response:

```json
{
    "meta": {
        "message": "Unauthenticated.",
        "code": "UNAUTHORIZED"
    },
    "data": []
}
```

### HTTP Request
`GET api/v1/serviceRequestOptions`

`HEAD api/v1/serviceRequestOptions`


<!-- END_f2646b0342d5943eae2fe3e181c0a698 -->

<!-- START_3c93952f49c4f16243a1bed8edfd4c8e -->
## Store a newly created resource in storage.

> Example request:

```bash
curl -X POST "http://localhost:8000/api/v1/serviceRequestOptions" \
-H "Accept: application/json"
```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://localhost:8000/api/v1/serviceRequestOptions",
    "method": "POST",
    "headers": {
        "accept": "application/json"
    }
}

$.ajax(settings).done(function (response) {
    console.log(response);
});
```


### HTTP Request
`POST api/v1/serviceRequestOptions`


<!-- END_3c93952f49c4f16243a1bed8edfd4c8e -->

<!-- START_ff01db5e2825fd2ea84222450e0e7ea0 -->
## Display the specified resource.

> Example request:

```bash
curl -X GET "http://localhost:8000/api/v1/serviceRequestOptions/{serviceRequestOption}" \
-H "Accept: application/json"
```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://localhost:8000/api/v1/serviceRequestOptions/{serviceRequestOption}",
    "method": "GET",
    "headers": {
        "accept": "application/json"
    }
}

$.ajax(settings).done(function (response) {
    console.log(response);
});
```

> Example response:

```json
{
    "meta": {
        "message": "Unauthenticated.",
        "code": "UNAUTHORIZED"
    },
    "data": []
}
```

### HTTP Request
`GET api/v1/serviceRequestOptions/{serviceRequestOption}`

`HEAD api/v1/serviceRequestOptions/{serviceRequestOption}`


<!-- END_ff01db5e2825fd2ea84222450e0e7ea0 -->

<!-- START_368d0dda417cb26bbf724caa71f44b99 -->
## Update the specified resource in storage.

> Example request:

```bash
curl -X PUT "http://localhost:8000/api/v1/serviceRequestOptions/{serviceRequestOption}" \
-H "Accept: application/json"
```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://localhost:8000/api/v1/serviceRequestOptions/{serviceRequestOption}",
    "method": "PUT",
    "headers": {
        "accept": "application/json"
    }
}

$.ajax(settings).done(function (response) {
    console.log(response);
});
```


### HTTP Request
`PUT api/v1/serviceRequestOptions/{serviceRequestOption}`

`PATCH api/v1/serviceRequestOptions/{serviceRequestOption}`


<!-- END_368d0dda417cb26bbf724caa71f44b99 -->

<!-- START_52365fbe9de9baa193129befbb5e1d10 -->
## Remove the specified resource from storage.

> Example request:

```bash
curl -X DELETE "http://localhost:8000/api/v1/serviceRequestOptions/{serviceRequestOption}" \
-H "Accept: application/json"
```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://localhost:8000/api/v1/serviceRequestOptions/{serviceRequestOption}",
    "method": "DELETE",
    "headers": {
        "accept": "application/json"
    }
}

$.ajax(settings).done(function (response) {
    console.log(response);
});
```


### HTTP Request
`DELETE api/v1/serviceRequestOptions/{serviceRequestOption}`


<!-- END_52365fbe9de9baa193129befbb5e1d10 -->

<!-- START_985d87fa04a157f2d8b59ef306bf6f06 -->
## Display a listing of the resource.

> Example request:

```bash
curl -X GET "http://localhost:8000/api/v1/orders" \
-H "Accept: application/json"
```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://localhost:8000/api/v1/orders",
    "method": "GET",
    "headers": {
        "accept": "application/json"
    }
}

$.ajax(settings).done(function (response) {
    console.log(response);
});
```

> Example response:

```json
{
    "meta": {
        "message": "Unauthenticated.",
        "code": "UNAUTHORIZED"
    },
    "data": []
}
```

### HTTP Request
`GET api/v1/orders`

`HEAD api/v1/orders`


<!-- END_985d87fa04a157f2d8b59ef306bf6f06 -->

<!-- START_c79cb2035f69ac8078c2cec9fc2fab4a -->
## Store a newly created resource in storage.

> Example request:

```bash
curl -X POST "http://localhost:8000/api/v1/orders" \
-H "Accept: application/json"
```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://localhost:8000/api/v1/orders",
    "method": "POST",
    "headers": {
        "accept": "application/json"
    }
}

$.ajax(settings).done(function (response) {
    console.log(response);
});
```


### HTTP Request
`POST api/v1/orders`


<!-- END_c79cb2035f69ac8078c2cec9fc2fab4a -->

<!-- START_13f4a2ba5be2993e266a0acf8d3bd280 -->
## Display the specified resource.

> Example request:

```bash
curl -X GET "http://localhost:8000/api/v1/orders/{order}" \
-H "Accept: application/json"
```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://localhost:8000/api/v1/orders/{order}",
    "method": "GET",
    "headers": {
        "accept": "application/json"
    }
}

$.ajax(settings).done(function (response) {
    console.log(response);
});
```

> Example response:

```json
{
    "meta": {
        "message": "Unauthenticated.",
        "code": "UNAUTHORIZED"
    },
    "data": []
}
```

### HTTP Request
`GET api/v1/orders/{order}`

`HEAD api/v1/orders/{order}`


<!-- END_13f4a2ba5be2993e266a0acf8d3bd280 -->

<!-- START_2e6d997181b1c50b2b94eaa14b66f016 -->
## Update the specified resource in storage.

> Example request:

```bash
curl -X PUT "http://localhost:8000/api/v1/orders/{order}" \
-H "Accept: application/json"
```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://localhost:8000/api/v1/orders/{order}",
    "method": "PUT",
    "headers": {
        "accept": "application/json"
    }
}

$.ajax(settings).done(function (response) {
    console.log(response);
});
```


### HTTP Request
`PUT api/v1/orders/{order}`

`PATCH api/v1/orders/{order}`


<!-- END_2e6d997181b1c50b2b94eaa14b66f016 -->

<!-- START_f34ad9d71f18dd67576cc6db60268192 -->
## Remove the specified resource from storage.

> Example request:

```bash
curl -X DELETE "http://localhost:8000/api/v1/orders/{order}" \
-H "Accept: application/json"
```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://localhost:8000/api/v1/orders/{order}",
    "method": "DELETE",
    "headers": {
        "accept": "application/json"
    }
}

$.ajax(settings).done(function (response) {
    console.log(response);
});
```


### HTTP Request
`DELETE api/v1/orders/{order}`


<!-- END_f34ad9d71f18dd67576cc6db60268192 -->

<!-- START_e50fee59f4f92349613ec6ac3f3ce097 -->
## api/v1/orderItems/sendLPO

> Example request:

```bash
curl -X POST "http://localhost:8000/api/v1/orderItems/sendLPO" \
-H "Accept: application/json"
```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://localhost:8000/api/v1/orderItems/sendLPO",
    "method": "POST",
    "headers": {
        "accept": "application/json"
    }
}

$.ajax(settings).done(function (response) {
    console.log(response);
});
```


### HTTP Request
`POST api/v1/orderItems/sendLPO`


<!-- END_e50fee59f4f92349613ec6ac3f3ce097 -->

<!-- START_de1049457c25265be4ece0e08d7c1df5 -->
## Display a listing of the resource.

> Example request:

```bash
curl -X GET "http://localhost:8000/api/v1/orderItems" \
-H "Accept: application/json"
```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://localhost:8000/api/v1/orderItems",
    "method": "GET",
    "headers": {
        "accept": "application/json"
    }
}

$.ajax(settings).done(function (response) {
    console.log(response);
});
```

> Example response:

```json
{
    "meta": {
        "message": "Unauthenticated.",
        "code": "UNAUTHORIZED"
    },
    "data": []
}
```

### HTTP Request
`GET api/v1/orderItems`

`HEAD api/v1/orderItems`


<!-- END_de1049457c25265be4ece0e08d7c1df5 -->

<!-- START_826bb17aeaa2c7dae6a2f7af931277dc -->
## Store a newly created resource in storage.

> Example request:

```bash
curl -X POST "http://localhost:8000/api/v1/orderItems" \
-H "Accept: application/json"
```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://localhost:8000/api/v1/orderItems",
    "method": "POST",
    "headers": {
        "accept": "application/json"
    }
}

$.ajax(settings).done(function (response) {
    console.log(response);
});
```


### HTTP Request
`POST api/v1/orderItems`


<!-- END_826bb17aeaa2c7dae6a2f7af931277dc -->

<!-- START_e30156944cfed522356340034e0bf2e8 -->
## Display the specified resource.

> Example request:

```bash
curl -X GET "http://localhost:8000/api/v1/orderItems/{orderItem}" \
-H "Accept: application/json"
```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://localhost:8000/api/v1/orderItems/{orderItem}",
    "method": "GET",
    "headers": {
        "accept": "application/json"
    }
}

$.ajax(settings).done(function (response) {
    console.log(response);
});
```

> Example response:

```json
{
    "meta": {
        "message": "Unauthenticated.",
        "code": "UNAUTHORIZED"
    },
    "data": []
}
```

### HTTP Request
`GET api/v1/orderItems/{orderItem}`

`HEAD api/v1/orderItems/{orderItem}`


<!-- END_e30156944cfed522356340034e0bf2e8 -->

<!-- START_e4de0461163b8319c8358dc93273aff4 -->
## Update the specified resource in storage.

> Example request:

```bash
curl -X PUT "http://localhost:8000/api/v1/orderItems/{orderItem}" \
-H "Accept: application/json"
```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://localhost:8000/api/v1/orderItems/{orderItem}",
    "method": "PUT",
    "headers": {
        "accept": "application/json"
    }
}

$.ajax(settings).done(function (response) {
    console.log(response);
});
```


### HTTP Request
`PUT api/v1/orderItems/{orderItem}`

`PATCH api/v1/orderItems/{orderItem}`


<!-- END_e4de0461163b8319c8358dc93273aff4 -->

<!-- START_e972713bf5822449ad1c291f776c8cf5 -->
## Remove the specified resource from storage.

> Example request:

```bash
curl -X DELETE "http://localhost:8000/api/v1/orderItems/{orderItem}" \
-H "Accept: application/json"
```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://localhost:8000/api/v1/orderItems/{orderItem}",
    "method": "DELETE",
    "headers": {
        "accept": "application/json"
    }
}

$.ajax(settings).done(function (response) {
    console.log(response);
});
```


### HTTP Request
`DELETE api/v1/orderItems/{orderItem}`


<!-- END_e972713bf5822449ad1c291f776c8cf5 -->

<!-- START_816db9c747aee1929d1aa8d679ab152a -->
## api/v1/reports

> Example request:

```bash
curl -X GET "http://localhost:8000/api/v1/reports" \
-H "Accept: application/json"
```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://localhost:8000/api/v1/reports",
    "method": "GET",
    "headers": {
        "accept": "application/json"
    }
}

$.ajax(settings).done(function (response) {
    console.log(response);
});
```

> Example response:

```json
{
    "meta": {
        "message": "Unauthenticated.",
        "code": "UNAUTHORIZED"
    },
    "data": []
}
```

### HTTP Request
`GET api/v1/reports`

`HEAD api/v1/reports`


<!-- END_816db9c747aee1929d1aa8d679ab152a -->

