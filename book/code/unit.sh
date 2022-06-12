
# Chapter 1
gcc -ansi c_008_01.c
gcc -ansi c_011_01.c
gcc -ansi c_013_01.c
gcc -ansi c_014_01.c
gcc -ansi c_015_01.c
gcc -ansi c_016_01.c
gcc -ansi c_016_02.c
gcc -ansi c_017_01.c
gcc -ansi c_020_01.c
gcc -ansi c_023_01.c
gcc -ansi -c c_024_01.c
gcc -ansi -Wno-return-type c_026_01.c
gcc -ansi -Wno-return-type c_029_01.c

# Chapter 3
gcc -ansi -c c_054_01.c
gcc -ansi c_055_01.c
gcc -ansi -c c_058_01.c
gcc -ansi -c -Wno-return-type c_058_02.c
gcc -ansi -c -Wno-return-type c_059_01.c
gcc -ansi -c -Wno-return-type c_060_01.c
gcc -ansi -c c_061_01.c

# Chapter 4
gcc -ansi c_066_01.c
gcc -ansi -c c_069_01.c
gcc -ansi -c c_070_01.c
gcc -ansi -c c_074_01.c
gcc -ansi -c c_075_01.c
# gcc -ansi -c c_078_01.c - lots of errors here
gcc -ansi -c -Wno-return-type c_079_01.c
gcc -ansi -c -Wno-return-type c_085_01.c
gcc -ansi -c -Wno-return-type c_085_02.c

# Chapter 5
# gcc -ansi -c -Wno-return-type c_097_01.c - steps on built-ins
gcc -ansi -c c_106_01.c
gcc -ansi -c c_107_01.c
gcc -ansi c_111_01.c
gcc -ansi c_111_02.c
gcc -ansi c_111_03.c
gcc -ansi -c c_112_01.c
gcc -ansi -c c_113_01.c
gcc -ansi -c c_115_01.c

# Chapter 6
# gcc -ansi -c c_125_01.c
# gcc -ansi -c c_131_01.c

# Chapter 7
gcc -ansi c_145_01.c -o lower
gcc -ansi c_150_01.c
gcc -ansi c_153_01.c
gcc -ansi -c c_154_01.c
# gcc -ansi c_155_01.c -  as there is no main function for this code

# Chapter 8
gcc -ansi c_161_01.c
gcc -ansi -c c_161_02.c
gcc -ansi -c c_162_01.c
gcc -ansi c_163_01.c
# gcc -ansi -c c_167_01.c
# gcc -ansi -c c_168_01.c
gcc -ansi -c c_171_01.c

rm a.out *.o lower
