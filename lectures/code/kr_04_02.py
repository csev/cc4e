def zap(y):
    print('Y start  zap:',y)
    y = 'CHANGED'
    print('Y end    zap:',y)

x = 'ORIGINAL'
print('X before zap:',x)
zap(x)
print('X after  zap:',x)
