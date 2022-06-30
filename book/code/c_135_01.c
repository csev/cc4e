#define HASHSIZE 100

hash(s) /* form hash value for string s */
char *s;
{
  int hashval;

  for (hashval = 0; *s != '\0'; )
    hashval += *s++;
  return(hashval % HASHSIZE);
}

