#include <stdio.h>
#define BLOCK_SIZE 512

int main(int argc, char **argv){
	char buffer[BLOCK_SIZE];
	while(!feof(stdin)){
		size_t bytes = fread(buffer, BLOCK_SIZE, sizeof(char),stdin);
		fwrite(buffer, bytes, sizeof(char),stdout);
	}

	printf("200\n");
	printf("Content-Type: text/html; charset=utf-8\n");
	printf("%s", argv[1]);
	printf("~~~卐~卐~ॐ~卐~卐~~~");
	return 0;
}