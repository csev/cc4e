import collections

dct = dict();

dct["z"] = "Catch phrase"
print(dct);
dct["z"] = "W"
print(dct);
dct["y"] = "B"
dct["c"] = "C"
dct["a"] = "D"
print(dct);
print("Length =", len(dct));

print("z=", dct.get("z", 404))
print("x=", dct.get("x", 404))

print("Sort by key");
dct = dict(sorted(dct.items()))
print(dct)

print("Sort by value");
dct = dict(sorted(dct.items(), key=lambda x: x[1]))
print(dct)

print("\nDump")
for key in dct:
    print(key+"="+dct[key])


