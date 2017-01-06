#include <stdio.h>
#define BLOCK_SIZE 512

void deal_with_it(){
	printf("ello planet earth !");
}

// our main function
int main(int argc, char **argv){
	char buffer[BLOCK_SIZE];
	while(!feof(stdin)){
		size_t bytes = fread(buffer, BLOCK_SIZE, sizeof(char), stdin);
		fwrite(buffer, bytes, sizeof(char), stdout);
	}

	// printing headers
	printf("200\n");
	printf("Content-Type: text/html; charset=utf-8\n");
	printf("%s", argv[1]);
	deal_with_it();
	return 0; // signifies 'success' of the status
}