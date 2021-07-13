#include <unistd.h>
#include <sys/mman.h>
#include <string.h>
#include <stdio.h>

/* https://stackoverflow.com/questions/18476002/execute-binary-machine-code-from-c/18477070#18477070 */

char code[] = {0x55,0x48,0x89,0xe5,0x89,0x7d,0xfc,0x48,
    0x89,0x75,0xf0,0xb8,0x2a,0x00,0x00,0x00,0xc9,0xc3,0x00};
/*
00000000004004b4 <main> 55                          push   %rbp
00000000004004b5 <main+0x1>  48 89 e5               mov    %rsp,%rbp
00000000004004b8 <main+0x4>  89 7d fc               mov    %edi,-0x4(%rbp)
00000000004004bb <main+0x7>  48 89 75 f0            mov    %rsi,-0x10(%rbp)
'return 42;'
00000000004004bf <main+0xb>  b8 2a 00 00 00         mov    $0x2a,%eax
'}'
00000000004004c4 <main+0x10> c9                     leaveq 
00000000004004c5 <main+0x11> c3                     retq 
*/

int main(int argc, char **argv) { 
    void *buf;

    /* copy code to executable buffer */    
    buf = mmap (0,sizeof(code),PROT_READ|PROT_WRITE|PROT_EXEC,
                MAP_PRIVATE|MAP_ANON,-1,0);
    memcpy (buf, code, sizeof(code));
    __builtin___clear_cache(buf, buf+sizeof(code)-1);  // on x86 this just stops memcpy from optimizing away as a dead store

    /* run code */
    int i = ((int (*) (void))buf)();
    printf("get this done. returned: %d\n", i);

    return 0;
}

