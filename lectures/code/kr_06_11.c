#include <stdio.h>
#include <string.h>

// https://stackoverflow.com/questions/14280336/convert-decimal-to-binary-in-c

char ch2b2_buffer[9];

char * ch2b2(char value)
{
    int i;
    ch2b2_buffer[8] = '\0';
    for (i = 7; i >= 0; --i, value >>= 1)
    {
        ch2b2_buffer[i] = (value & 1) + '0';
    }
    return ch2b2_buffer;
}

int main() {
#if __BYTE_ORDER__ == __ORDER_LITTLE_ENDIAN__
    union instruction {
        char ch;
        struct {
            unsigned bottom : 6;
            unsigned top : 2;
        } parts;
    } ;
#else
    union instruction {
        char ch;
        struct {
            unsigned top : 2;
            unsigned bottom : 6;
        } parts;
    } ;
#endif

    union instruction inst;

    inst.ch = 0xF1; /* 11110001 */

    printf("%s %x %x\n",
        ch2b2(inst.ch),
        inst.parts.top,
        inst.parts.bottom);
}

