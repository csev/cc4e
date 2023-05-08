#include <iostream>

class TenInt {
  private:
    int values[10];

  public:
    int & operator [](const int & index) {
        printf("-- Returning reference to %d\n", index);
        return values[index];
    }
};

int main() {
    TenInt ten;
    ten[1] = 40;
    printf("printf ten[1] contains %d\n", ten[1]);

    ten[5] = ten[1] + 2;
    printf("Done assigning ten[5]\n");
    printf("printf ten[5] contains %d\n", ten[5]);
}

// rm -f a.out; g++ cc_04_04.cpp; a.out; rm -f a.out

