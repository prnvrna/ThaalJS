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

function print_arguments_on_seaparate_lines {
	printf "%s\n" Print arguments on "separate lines"
}

function using_example_percent_b {
	printf "%b\n" "Hello\nWorld" "12\tword"
}

function print_as_decimal {
	printf "%.2f\n" $1
}

function print_as_exponential {
	printf "%e\n" $1
}

function print_as_hex {
	printf "%x\n" $1
}

function print_color_code_from_rgb_to_hex {
	printf "#%02x%02x%02x\n" $1 $2 $3
}

function print_flush_example_one {
	printf "%8s %-15s:\n" first second third fourth fifth sixth
}

function print_flush_example_two {
	printf "%04d\n" 12 23 56 123 255 2121
}