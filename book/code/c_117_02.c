swap(px, py) /* interchange *px and *py */
char *px[], *py[];
{
  char *temp;

  temp = *px;
  *px = *py;
  *py = temp;
}
