#include <stdio.h>
#include <string.h>

void zap(char y[]) {
    printf("Y start  zap: %s\n",y);
    strcpy(y, "CHANGED");
    printf("Y end    zap: %s\n",y);
}

int main(){
    char x[] = "ORIGINAL";
    printf("X before zap: %s\n",x);
    zap(x);
    printf("X after  zap: %s\n",x);
}
