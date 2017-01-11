#!/bin/bash

# including our functions
. "$(basename $(dirname $0))/functions.sh"
# handling execution
print_header $1 # passing delimeter to the function
# examples
##say_ello
##print_as_decimal 0xff
##print_as_decimal 011
##print_as_exponential 0xff
##print_as_exponential 011
##print_as_hex 1120900
##print_as_hex 011
##print_as_hex 10
##print_color_code_from_rgb_to_hex 65 105 225
##print_color_code_from_rgb_to_hex 255 255 255
##print_color_code_from_rgb_to_hex 0 0 0
##print_flush_example_one
##print_flush_example_two
##echo $(store_printf_output_to_a_variable)
##print_intros_using_single_printf
##test_if_file_exists /etc/fstab
##check_if_type_of_file_is_regular /etc/fstab
##check_if_type_of_file_is_regular /etc/
##check_if_type_of_file_is_symbolic_link /etc/fstab
##check_if_type_of_file_is_symbolic_link /etc/
##check_if_type_of_file_is_symbolic_link "$(basename $(dirname $0))/link2mainsh"
##check_if_directory /etc/fstab
##check_if_directory /etc/
##check_if_executable /etc/fstab
##check_if_executable /etc/
##check_if_executable /etcsddx/
##check_if_executable "$(basename $(dirname $0))/link2mainsh"
##check_if_executable "$(basename $(dirname $0))/main.sh"
##check_if_numbers_are_equal 2 3
##check_if_numbers_are_equal 2 2
##check_if_numbers_are_unequal 2 3
##check_if_numbers_are_unequal 2 2
##check_if_strings_are_equal pranav rana
##check_if_strings_are_equal rana rana
##check_if_strings_are_unequal pranav rana
##check_if_strings_are_unequal rana rana
##check_if_value_is_empty ""
##check_if_value_is_empty pranav
##check_if_value_is_nonempty ""
##check_if_value_is_nonempty pranav
##check_if_1_is_greater_than_2 4 8
##check_if_1_is_greater_than_2 8 4
##check_if_1_is_greater_than_2 39 40.2
##check_if_1_is_greater_than_2 41 40.2
##check_if_1_is_greater_than_2 abc def
##check_if_1_is_greater_than_2 def abc
##check_if_1_is_less_than_2 4 8
##check_if_1_is_less_than_2 8 4
##check_if_1_is_less_than_2 39 40.2
##check_if_1_is_less_than_2 41 40.2
##check_if_1_is_less_than_2 abc def
##check_if_1_is_less_than_2 def abc
##check_equality_with_logical_and_operator 22 22 33 33
##check_equality_with_logical_and_operator 22 33 22 33
##check_equality_with_logical_or_operator 22 22 33 33
##check_equality_with_logical_or_operator 22 33 22 33
##print_user_greetings pranav
##print_user_greetings rana
##print_user_greetings fuckyou