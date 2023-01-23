
def zap(x):
    print('X at start of zap:',x);
    x = 'CHANGED'
    print('X at end of zap:',x);

x = 'ORIGINAL'
print('X before zap:',x);
zap(x)
print('X after zap:',x);
