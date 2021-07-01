
/** Program which demonstrated the use of a "lock file" for program synch

  Written by: Charles Severance - Fri Aug 26 10:17:24 EDT 1994

  This program makes use of the "open-create-exclusive" flag to synchronize
  access to a file.  To run, compile and run many copies at the same time:


    % cc filock.c
    % a.out first &
    % a.out second &
    % a.out third 
       ...
  or 

    % a.out first & ; a.out second & ; a.out third

  And watch the synchronization occur.

  Make sure to run this on local disk if possible.  Different NFS's will work
  different ways.

  Technique:

  The file we are trying to serialize access to will be called "sync"
  Another file called "sync.lock" will be used to "protect" the sync file.

  When "sync.lock" exists, access to the "sync" file is denied.

*/

#include <stdio.h>
#include <fcntl.h>
#include <sys/stat.h>
#include <sys/types.h>

main(int argc, char *argv[]) 

{ 

  int lines;
  int tries;
  FILE *fp;
  int lfno;
  int pidno;
  char tmp[100];

  if ( argc != 2 ) {
    fprintf(stderr,"Please give me a parameter...\n");
    exit();
  }

  pidno = getpid();

/* Write some lines... */

  for(lines=1;lines<=10;lines++) {

   printf("%s Starting line %d -----\n",argv[1],lines);

   sleep(1);   /* Give someone else a shot - sleep without the lock */

/* Wait for the lock file */

   for(tries=1;tries<10;tries++) {
     lfno = open("sync.lock", O_CREAT + O_EXCL + O_RDWR );
     if ( lfno > 0 ) break;
     printf(" zzzzzzzz %s Sleeping 1 second\n",argv[1]);
     sleep(1);
   }

   if ( tries >= 10 ) {
     fprintf(stderr,"******************** %s ******************\n",argv[1]);
     fprintf(stderr,"That lock just never came free...\n");
     fprintf(stderr,"Often we do something drastic here like assume the\n");
     fprintf(stderr,"Holding the lock has died and just blast the lock\n");
     fprintf(stderr,"That is what we will do here...\n");
     unlink("sync.lock");
     continue;
   }

   /* For debugging, it is traditional to write our pid to the file... */

   sprintf(tmp,"%d",pidno);

   write(lfno,tmp,strlen(tmp));   /* Ugg - using write */
   close(lfno);   /* We can close the file now..  Its existance is the lock */

   printf("%s got the lock....\n",argv[1]);

   sleep(1);  /* Sleep with the lock to be tacky */

/* Open the file */

   fp = fopen("sync","a");
   if ( fp == NULL )  {
     fprintf(stderr,"Unable to open sync file\n");
     unlink("sync.lock");  /* To be a good citizen */
     exit();
   }
 
   printf("%s writing record %d ....\n",argv[1],lines);
   fprintf(fp,"%s writing record %d ....\n",argv[1],lines);

   fclose(fp);  /* Close the file */
  
   unlink("sync.lock");   /* unlock for someone else */

}

} /* End of the main program */
   

