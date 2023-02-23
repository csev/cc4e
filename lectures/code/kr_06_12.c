#include <stdio.h>

int main() {
#if __BYTE_ORDER__ == __ORDER_LITTLE_ENDIAN__
    union format {
        char ch;
        struct {
            unsigned bottom : 6;
            unsigned opcode : 2;
        } inst;
    } ;
#else
    union format {
        char ch;
        struct {
            unsigned opcode : 2;
            unsigned bottom : 6;
        } inst;
    } ;
#endif

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
