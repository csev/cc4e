
lines = list()
hand = open('romeo.txt')
for line in hand:
    lines.append(line.rstrip())

for line in lines:
    print(line)

