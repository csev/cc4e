d = dict()

print("Testing dict class\n");
d["z"] = 8
d["z"] = 1
d["y"] = 9
d["b"] = 3
d["a"] = 4
print(d);

print("z=%d" % (d.get("z", 42), ));
print("x=%d" %  (d.get("x", 42), ));

items = iter(d.items())
print(type(items));

print("Iterate");
entry = next(items, False)
while (entry) :
    print(entry)
    entry = next(items, False)

# python3 cc_04_03.py
