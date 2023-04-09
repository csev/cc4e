
class TenInt:
    values = dict()

    def __setitem__(self, index, value) :
        self.values[index] = value

    def __getitem__(self, index) :
        return self.values[index]

ten = TenInt()
ten[1] = 40;
print("print ten[1] contains", ten[1]);

ten[5] = ten[1] + 2;
print("Done assigning ten[5]");
print("print ten[5] contains", ten[5]);

