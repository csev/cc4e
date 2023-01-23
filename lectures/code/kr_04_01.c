#include <stdio.h>
#include <string.h>

void zap(char x[]) {
    printf("X at start of zap: %s\n",x);
    strcpy(x, "CHANGED");
    printf("X at end of zap: %s\n",x);
}

int main(){
    char x[] = "ORIGINAL";
    printf("X after zap: %s\n",x);
    zap(x);
    printf("X after zap: %s\n",x);
}
