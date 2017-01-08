#!/bin/bash

# including our functions
. "$(basename $(dirname $0))/functions.sh"
# handling execution
print_header $1 # passing delimeter to the function
# examples
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
