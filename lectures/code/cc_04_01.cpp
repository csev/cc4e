#include <iostream>
#include <map>
using namespace std;

int main() {
    map<string, int> mp;

    cout << "Testing map class\n";
    mp["z"] = 8;
    mp["z"] = 1;
    mp["y"] = 2;
    mp["b"] = 3;
    mp["a"] = 4;
    for (auto i = mp.begin(); i != mp.end(); ++i) {
        cout << i->first << " " << i->second << "\n";
    }

    cout << "z=" << (mp.count("z") ? mp["z"] : 42) << endl;
    cout << "x=" << (mp.count("x") ? mp["x"] : 42) << endl;

    cout << "\nIterate forwards\n";
    for (auto i = mp.begin(); i != mp.end(); ++i) {
        cout << "Key = " << i->first << ", Value = " << i->second << endl;
    }
}

// rm -f a.out; g++ -std=c++11 cc_04_01.cpp; a.out; rm -f a.out
