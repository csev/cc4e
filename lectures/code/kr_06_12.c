#include <stdio.h>

int main() {
    union format {
        char ch;
        struct {
            unsigned opcode : 2;
            unsigned bottom : 6;
        } inst;
    } ;

    unsigned int i, op;
    union format bits;

    while(scanf("%x", &i) == 1 ) {
        bits.ch = i;
        op = bits.inst.opcode;
        printf("%x %d\n", bits.ch, op);
        if ( op == 2 || op == 3 ) printf("opcode %d\n",op);
        else printf("%c\n", bits.ch);
    }
}
