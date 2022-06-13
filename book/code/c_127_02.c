#define LETTER 'a'
#define DIGIT  '0'

type(c) /* return type of ASCII character */
int c;
{
    if (c >= 'a' && c <= 'z' || c >= 'A' && c <= 'Z')
        return (LETTER);

    else if (c >= '0' && c <= '9')
        return (DIGIT);
    else
        return(c);
}
