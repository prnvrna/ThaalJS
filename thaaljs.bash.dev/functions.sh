function print_header {
	printf "%d\n" 200
	echo "Content-Type: text/plain; charset=utf-8"
	printf "%s" $1
}

function say_ello {
	printf "%s\n" "ello planet earth!"
}

function print_general_info {
	printf "I am running under process: %d\n" $$
	printf "The exit code of the last eecuted command is: %d\n" $?
	printf "Last argumnt to the previous command is: %s\n" $_
	printf "PID of the last command excuted in the background is: %d\n" $!
	printf "Options flag that is currently in effect is: %s\n" $-
}