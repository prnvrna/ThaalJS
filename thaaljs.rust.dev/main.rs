use std::env;
use std::io::{self, BufRead};

fn main(){
	let args: Vec<_> = env::args().collect();
	let mut line = String::new();
	let stdin = io::stdin();
	stdin.lock().read_line(&mut line).expect("Could not read line");

	print!("200{}", "\n");
	print!("Content-Type: text/html; charset=utf-8{}", "\n");
	print!("{}", args[1]);
	ello(); // i take it from here
}

fn ello(){
	print!("~~~卐~卐~ॐ~卐~卐~~~");
}