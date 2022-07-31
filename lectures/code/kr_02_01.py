num = int(input('Enter a base-10 number: '))
out = ''
val = num
while (val > 0 ) :
    digit = val % 8
    print(val,'% 8 = ',digit)
    out = str(digit) + out;
    new = int(val / 8)
    print(val,'/ 8 = ',new)
    val = new
print(num, 'in base-8 is', out)

digits = '0123456789abcdef'
out = ''
val = num
while (val > 0 ) :
    digit = val % 16
    print(val,'% 16 = ',digit)
    out = digits[digit:digit+1] + out;
    new = int(val / 16)
    print(val,'/ 16 = ',new)
    val = new
print(num, 'in base-16 is', out)
