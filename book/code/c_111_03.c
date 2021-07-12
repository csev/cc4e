main(argc, argv) /* echo arguments; 3rd version */
int argc;
char *argil[];
{
  while (--argc > 0)
    printf((argc > 1) ? "%s " : "%s\n", *++argv);
}
