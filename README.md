# Akto Vulnerable To Do List API

This is a purposely vulnerable API!

## REST

There is a standard JSON REST API at `/api/REST/tasks`. Routes included are:

- `GET /REST/tasks`: get all tasks
- `POST /REST/tasks`': create a task. Parameters are simply "name (string)" and "done" (boolean).
- `PUT /REST/tasks/{id}`: update a task.
- `DELETE /REST/tasks/{id}`: delete a task.

## GraphQL

The GraphQL endpoint is at `/graphql`. There is also a GraphiQL instance at `graphiql` to be used as a playground.

## JSON-RPC

A JSON-RPC API is available at `/api/JSON-RPC/tasks`.

### Creating a task

Create a task by sending the following request
```
POST /api/JSON-RPC/tasks HTTP/1.1
Host: vuln-task-mgmt-app.test
User-Agent: curl/7.87.0
Accept: */*
Content-Type: application/json
Content-Length: 112
Connection: close

{
	"jsonrpc":"2.0",
	"method":"task@create",
	"id":1,
"params":{
"name":"Get groceries",
"done": 0
}
}
```

The response should be something like this:

```
HTTP/1.1 200 OK
Server: nginx/1.22.1
Content-Type: application/json
Connection: close
Vary: Accept-Encoding
X-Powered-By: PHP/8.2.8
Cache-Control: no-cache, private
Date: Mon, 28 Aug 2023 10:11:55 GMT
X-RateLimit-Limit: 60
X-RateLimit-Remaining: 56
Access-Control-Allow-Origin: *
Content-Length: 169

{"id":"1","result":{"name":"Get groceries","done":0,"updated_at":"2023-08-28T10:11:55.000000Z","created_at":"2023-08-28T10:11:55.000000Z","id":20},"jsonrpc":"2.0"}
```


### List tasks

You can list tasks with the following request:

```
POST /api/JSON-RPC/tasks HTTP/1.1
Host: vuln-task-mgmt-app.test
User-Agent: curl/7.87.0
Accept: */*
Content-Type: application/json
Content-Length: 52
Connection: close

{
	"jsonrpc":"2.0",
	"method":"task@list",
	"id":1
}
```

The response:

```
HTTP/1.1 200 OK
Server: nginx/1.22.1
Content-Type: application/json
Connection: close
Vary: Accept-Encoding
X-Powered-By: PHP/8.2.8
Cache-Control: no-cache, private
Date: Mon, 28 Aug 2023 10:17:29 GMT
X-RateLimit-Limit: 60
X-RateLimit-Remaining: 56
Access-Control-Allow-Origin: *
Content-Length: 452

{"id":"1","result":[{"id":13,"created_at":"2023-08-21T06:39:22.000000Z","updated_at":"2023-08-28T09:39:15.000000Z","name":"Buy a birthday present for Jessica","done":0},{"id":14,"created_at":"2023-08-21T06:39:29.000000Z","updated_at":"2023-08-21T06:39:29.000000Z","name":"Pick up groceries","done":0},{"id":17,"created_at":"2023-08-28T10:11:51.000000Z","updated_at":"2023-08-28T10:11:51.000000Z","name":"finish JSON-RPC API","done":0}],"jsonrpc":"2.0"}
```

### Delete task

The request:
```
POST /api/JSON-RPC/tasks HTTP/1.1
Host: vuln-task-mgmt-app.test
User-Agent: curl/7.87.0
Accept: */*
Content-Type: application/json
Content-Length: 77
Connection: close

{
	"jsonrpc":"2.0",
	"method":"task@delete",
	"id":1,
"params":{"id":20
}
}
```

The response:
```
HTTP/1.1 200 OK
Server: nginx/1.22.1
Content-Type: application/json
Connection: close
Vary: Accept-Encoding
X-Powered-By: PHP/8.2.8
Cache-Control: no-cache, private
Date: Mon, 28 Aug 2023 10:17:11 GMT
X-RateLimit-Limit: 60
X-RateLimit-Remaining: 59
Access-Control-Allow-Origin: *
Content-Length: 40

{"id":"1","result":true,"jsonrpc":"2.0"}
```

### Update task

In this case, we are updating the task with id "17" as "done". Here's the request:

```
POST /api/JSON-RPC/tasks HTTP/1.1
Host: vuln-task-mgmt-app.test
User-Agent: curl/7.87.0
Accept: */*
Content-Type: application/json
Content-Length: 88
Connection: close

{
	"jsonrpc":"2.0",
	"method":"task@update",
	"id":1,
"params":{"id":17,
"done":1
}
}
```

The response:
```
HTTP/1.1 200 OK
Server: nginx/1.22.1
Content-Type: application/json
Connection: close
Vary: Accept-Encoding
X-Powered-By: PHP/8.2.8
Cache-Control: no-cache, private
Date: Mon, 28 Aug 2023 10:19:36 GMT
X-RateLimit-Limit: 60
X-RateLimit-Remaining: 59
Access-Control-Allow-Origin: *
Content-Length: 40

{"id":"1","result":true,"jsonrpc":"2.0"}
```
