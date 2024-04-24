#define LETTER 'a'
#define DIGIT  '0'

getword(w, lim) /* get next word from input */
char *w;
int lim;
{
    int c, t;
    if (type(c = *w++ = getch()) != LETTER) {
        *w = '\0';
        return(c);

    }

    while (--lim > 0) {
        t = type(c = *w++ = getch());
        if (t != LETTER && t != DIGIT) {
            ungetch(c);
            break;
        }
    }
    *(w-1) = '\0';
    return (LETTER);
}
