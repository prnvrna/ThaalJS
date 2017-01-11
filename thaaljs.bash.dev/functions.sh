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

function store_printf_output_to_a_variable {
	local myintro
	printf -v myintro "%s, my name is %s" "Namaste" "Pranav Rana"
	echo $myintro
}

function print_intros_using_single_printf {
	# printf "%s, my name is %s\n" "Namaste" "Pranav Rana" "Ello" "Rana Pranav"
	printf "%s, my name is %s\n" \
		"Namaste" "Pranav Rana" \
		"Ello" "Rana Pranav"
}

function test_if_file_exists {
	[ -e $1 ]
	printf "Result: %s\n" $?
}

function check_if_type_of_file_is_regular {
	[ -f $1 ]
	printf "Result: %s\n" $?
}

function check_if_type_of_file_is_symbolic_link {
	[ -h $1 ]
	printf "Result: %s\n" $?
}

function check_if_directory {
	[ -d $1 ]
	printf "Result: %s\n" $?
}

function check_if_executable {
	[ -x $1 ]
	printf "Result: %s\n" $?
}

function check_if_numbers_are_equal {
	[ $1 -eq $2 ]
	printf "Result: %s\n" $?
}

function check_if_numbers_are_unequal {
	[ $1 -ne $2 ]
	printf "Result: %s\n" $?
}

function check_if_strings_are_equal {
	[ $1 = $2 ]
	printf "Result: %s\n" $?
}

function check_if_strings_are_unequal {
	[ $1 != $2 ]
	printf "Result: %s\n" $?
}

function check_if_value_is_empty {
	[ -z $1 ]
	printf "Result: %s\n" $?
}

function check_if_value_is_nonempty {
	[ -n $1 ]
	printf "Result: %s\n" $?
}

function check_if_1_is_greater_than_2 {
	[ $1 \> $2 ]
	printf "Result: %s\n" $?
}

function check_if_1_is_less_than_2 {
	[ $1 \< $2 ]
	printf "Result: %s\n" $?
}

function check_equality_with_logical_and_operator {
	[ $1 = $2 -a $3 = $4 ]
	printf "Result: %s\n" $?
}

function check_equality_with_logical_or_operator {
	[ $1 = $2 -o $3 = $4 ]
	printf "Result: %s\n" $?
}

function print_user_greetings {
	if [ $1 != "" -a $1 != "fuckyou" ]
	then
		printf "Welcome %s\n" $1
	elif [ $1 = "fuckyou" ]
	then
		printf "Go fuck yourself\n"
	else
		printf "Get out\n"
	fi
}