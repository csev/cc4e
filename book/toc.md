
**CONTENTS**

**Preface ix**

**Chapter 0 Introduction 1**

**Chapter 1 A Tutorial Introduction 5**

1.1 Getting Started 5

1.2 Variables and Arithmetic 8

1.3 The For Statement 11

1.4 Symbolic Constants 12

1.5 A Collection of Useful Programs 13

1.6 Arrays 20

1.7 Functions 22

1.8 Arguments — Call by Value 24

1.9 Character Arrays 25

1.10 Scope; External Variables 28

1.11 Summary 31

**Chapter 2 Types, Operators and Expressions 33**

2.1 Variable Names 33

2.2 Data Types and Sizes 33

2.3 Constants 34

2.4 Declarations 36

2.5 Arithmetic Operators 37

2.6 Relational and Logical Operators 38

2.7 Type Conversions 39

2.8 Increment and Decrement Operators 42

2.9 Bitwise Logical Operators **44**

2.10 Assignment Operators and Expressions 46

2.11 Conditional Expressions 47

2.12 Precedence and Order of Evaluation 48

| Vi THE C PROGRAMMING LANGUAGE | |
| --- | --- |
| **Chapter 3** | **Control Flow** | **51** |
| 3.1 | Statements and Blocks | 51 |
| 3.2 | If-Else | 51 |
| 3.3 | Else-If | 53 |
| 3.4 | Switch | 54 |
| 3.5 | Loops - While and For | 56 |
| 3.6 | Loops - Do-while | 59 |
| 3.7 | Break | 61 |
| 3.8 | Continue | 62 |
| 3.9 | Goto&#39;s and Labels | 62 |
| **Chapter 4** | **Functions and Program Structure** | **65** |
| 4.1 | Basics | 65 |
| 4.2 | Functions Returning Non-Integers | 68 |
| 4.3 | More on Function Arguments | 71 |
| 4.4 | External Variables | 72 |
| 4.5 | Scope Rules | 76 |
| 4.6 | Static Variables | 80 |
| 4.7 | Register Variables | 81 |
| 4.8 | Block Structure | 81 |
| 4.9 | Initialization | 82 |
| 4.10 | Recursion | 84 |
| 4.11 | The C Preprocessor | 86 |
| **Chapter 5** | **Pointers and Arrays** | **89** |
| 5.1 | Pointers and Addresses | 89 |
| 5.2 | Pointers and Function Arguments | 91 |
| 5.3 | Pointers and Arrays | 93 |
| 5.4 | Address Arithmetic | 96 |
| 5.5 | Character Pointers and Functions | 99 |
| 5.6 | Pointers are not Integers | 102 |
| 5.7 | Multi-Dimensional Arrays | 103 |
| 5.8 | Pointer Arrays; Pointers to Pointers | 105 |
| 5.9 | Initialization of Pointer Arrays | 109 |
| 5.10 | Pointers vs. Multi-dimensional Arrays | 110 |
| 5.11 | Command-line Arguments | 110 |
| 5.12 | Pointers to Functions | 114 |
| **Chapter 6** | **Structures** | **119** |
| 6.1 | Basics | 119 |
| 6.2 | Structures and Functions | 121 |
| 6.3 | Arrays of Structures | 123 |

| | CONTENTS | Vii |
| --- | --- | --- |
| 6.4 | Pointers to Structures | 128 |
| 6.5 | Self-referential Structures | 130 |
| 6.6 | Table Lookup | 134 |
| 6.7 | Fields | 136 |
| 6.8 | Unions | 138 |
| 6.9 | Typedef | 140 |
| **Chapter 7** | **Input and Output** | **143** |
| 7.1 | Access to the Standard Library | 143 |
| 7.2 | Standard Input and Output - Getchar and Putchar | 144 |
| 7.3 | Formatted Output - Printf | 145 |
| 7.4 | Formatted Input - Scanf | 147 |
| 7.5 | In-memory Format Conversion | 150 |
| 7.6 | File Access | 151 |
| 7.7 | Error Handling - Stderr and Exit | 154 |
| 7.8 | Line Input and Output | 155 |
| 7.9 | Some Miscellaneous Functions | 156 |
| **Chapter 8** | **The UNIX System Interface** | **159** |
| 8.1 | File Descriptors | 159 |
| 8.2 | Low Level I/O - Read and Write | 160 |
| 8.3 | Open, Creat, Close, Unlink | 162 |
| 8.4 | Random Access - Seek and Lseek | 164 |
| 8.5 | Example - An Implementation of Fopen and Getc | 165 |
| 8.6 | Example - Listing Directories | 169 |
| 8.7 | Example - A Storage Allocator | 173 |
| **Appendix A** | **C Reference Manual** | **179** |
| 1. | Introduction | 179 |
| 2. | Lexical conventions | 179 |
| 3. | Syntax notation | 182 |
| 4. | What&#39;s in a name? | 182 |
| 5. | Objects and lvalues | 183 |
| 6. | Conversions | 183 |
| 7. | Expressions | 185 |
| 8. | Declarations | 192 |
| 9. | Statements | 201 |
| 10. | External definitions | 204 |
| 11. | Scope rules | 205 |
| 12. | Compiler control lines | 207 |
| 13. | Implicit declarations | 208 |
| 14. | Types revisited | 209 |
| 15. | Constant expressions | 211 |

viii THE C PROGRAMMING LANGUAGE

1. Portability considerations 211
2. Anachronisms 212
3. Syntax Summary 214

