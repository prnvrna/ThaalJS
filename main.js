#!/usr/bin/node

var http = require('http')
var os = require('os')
var fs = require('fs')
var spawn = require('child_process').spawn
var routes = JSON.parse(fs.readFileSync('./routes.js').toString())
var data_type_boundary = '~~~'+Math.random()+Date.now()+'~~~卐~卐~ॐ~卐~卐~~~'+Date.now()+Math.random()+'~~~'
var port = 8080

http.createServer(function(request, response){
	/* pre-check */
	if(request.headers.host in routes != true){ // we simply bail with no clue whatsoever
		response.end()
		return
	}
	var spawned_one = spawn(routes[request.headers.host], [data_type_boundary, request.url, request.method, JSON.stringify(request.headers)])

	/* handling process input */
	request.on('data', function(chunk){
		spawned_one.stdin.write(chunk)
	})
	request.on('end', function(){
		spawned_one.stdin.end()
	})

	/* handling process output */
	var the_output = ''
	var headers_sent = false
	var process_done_with_sending_output = false
	var regular_outputter = function(){
		if(headers_sent){
			response.write(the_output)
			the_output = '' // resetting our output buffer to keep low on memory and this data has been flushed
		}else if(!headers_sent && the_output.search(data_type_boundary) != -1){ // headers not sent (and we do have em in our buffer), lets see what we can do
			var splitted_response = the_output.split(data_type_boundary)
			var our_headers = splitted_response[0].trim().split(os.EOL)
			var status_code_to_set = our_headers.shift()
			var headers_to_set = {}
			for(var i in our_headers){
				var header_to_set = our_headers[i].split(':')
				headers_to_set[header_to_set[0].trim()] = header_to_set[1].trim()
			}
			response.writeHead(status_code_to_set, headers_to_set)
			headers_sent = true // no need to land here in this block again
			the_output = the_output.replace(splitted_response[0], '').replace(data_type_boundary, '') // we now remove the header part from the process's output stream
		}

		process_done_with_sending_output == true && the_output == ''
		 ? response.end() // we are done with our response
		 : setTimeout(regular_outputter, 10) // we will have to come back later
	}
	regular_outputter() // we need to start it once
	spawned_one.stdout.on('data', function(data){
		the_output += data
	})
	spawned_one.stdout.on('close', function(){
		process_done_with_sending_output = true
		spawned_one.stdout.end()
	})

	/* other important events */
	spawned_one.stderr.on('data', function(data){
		response.write(data)
	})
	spawned_one.on('close', function(code){
		spawned_one.kill()
	})
}).listen(port)