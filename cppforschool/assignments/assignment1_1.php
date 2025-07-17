<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>C++ Programs</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
       <?php include ('../navigation_menu.php');   ?>
    <div class="container mt-4">
        <h2 class="text-center mb-4">C++ Programs with Collapsible Answers</h2>
        <div class="accordion" id="programAccordion">
            <!-- Program 1 -->
            <div class="accordion-item">
                <h2 class="accordion-header" id="headingOne">
                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                        1. Write a program to print HELLO WORLD on screen.
                    </button>
                </h2>
                <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#programAccordion">
                    <div class="accordion-body">
                        <pre>
#include &lt;iostream&gt;
using namespace std;

int main() {
    cout &lt;&lt; "Hello world";
    return 0;
}
                        </pre>
                    </div>
                </div>
            </div>

            <!-- Program 2 -->
            <div class="accordion-item">
                <h2 class="accordion-header" id="headingTwo">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                        2. Write a program to display a formatted table using a single cout statement.
                    </button>
                </h2>
                <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#programAccordion">
                    <div class="accordion-body">
                        <pre>
#include &lt;iostream&gt;
using namespace std;

int main() {
    cout &lt;&lt; "subject" &lt;&lt; "\tmarks" &lt;&lt; "\nmathematics\t" &lt;&lt; 90 
         &lt;&lt; "\ncomputer\t" &lt;&lt; 77 &lt;&lt; "\nchemistry\t" &lt;&lt; 69;
    return 0;
}
                        </pre>
                    </div>
                </div>
            </div>

            <!-- Program 3 -->
            <div class="accordion-item">
                <h2 class="accordion-header" id="headingThree">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                        3. Write a program which accepts two numbers and prints their sum.
                    </button>
                </h2>
                <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#programAccordion">
                    <div class="accordion-body">
                        <pre>
#include &lt;iostream&gt;
using namespace std;

int main() {
    int a, b, c;
    cout &lt;&lt; "\nEnter first number : ";
    cin &gt;&gt; a;
    cout &lt;&lt; "\nEnter second number : ";
    cin &gt;&gt; b;
    c = a + b;
    cout &lt;&lt; "\nThe Sum is : " &lt;&lt; c;
    return 0;
}
                        </pre>
                    </div>
                </div>
            </div>

            <!-- Program 4 -->
            <div class="accordion-item">
                <h2 class="accordion-header" id="headingFour">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                        4. Write a program to convert temperature from Fahrenheit to Celsius.
                    </button>
                </h2>
                <div id="collapseFour" class="accordion-collapse collapse" aria-labelledby="headingFour" data-bs-parent="#programAccordion">
                    <div class="accordion-body">
                        <pre>
#include &lt;iostream&gt;
using namespace std;

int main() {
    float F, C;
    cout &lt;&lt; "\nEnter temperature in Fahrenheit : ";
    cin &gt;&gt; F;
    C = 5 * (F - 32) / 9;
    cout &lt;&lt; "Temperature in Celsius is : " &lt;&lt; C;
    return 0;
}
                        </pre>
                    </div>
                </div>
            </div>

            <!-- Program 5 -->
            <div class="accordion-item">
                <h2 class="accordion-header" id="headingFive">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFive" aria-expanded="false" aria-controls="collapseFive">
                        5. Write a program to calculate simple interest.
                    </button>
                </h2>
                <div id="collapseFive" class="accordion-collapse collapse" aria-labelledby="headingFive" data-bs-parent="#programAccordion">
                    <div class="accordion-body">
                        <pre>
#include &lt;iostream&gt;
using namespace std;

int main() {
    int p, r, t, i;
    cout &lt;&lt; "Enter Principle : ";
    cin &gt;&gt; p;
    cout &lt;&lt; "Enter Rate : ";
    cin &gt;&gt; r;
    cout &lt;&lt; "Enter Time : ";
    cin &gt;&gt; t;
    i = (p * r * t) / 100;
    cout &lt;&lt; "Simple interest is : " &lt;&lt; i;
    return 0;
}
                        </pre>
                    </div>
                </div>
            </div>

            <!-- Program 6 -->
            <div class="accordion-item">
                <h2 class="accordion-header" id="headingSix">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseSix" aria-expanded="false" aria-controls="collapseSix">
                        6. Write a program to display the ASCII value of a character.
                    </button>
                </h2>
                <div id="collapseSix" class="accordion-collapse collapse" aria-labelledby="headingSix" data-bs-parent="#programAccordion">
                    <div class="accordion-body">
                        <pre>
#include &lt;iostream&gt;
using namespace std;

int main() {
    char ch;
    cout &lt;&lt; "\nEnter any character : ";
    cin &gt;&gt; ch;
    cout &lt;&lt; "ASCII equivalent is : " &lt;&lt; int(ch);
    return 0;
}
                        </pre>
                    </div>
                </div>
            </div>

                        <!-- Program 7 -->
            <div class="accordion-item">
                <h2 class="accordion-header" id="headingSeven">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseSeven" aria-expanded="false" aria-controls="collapseSeven">
                        7. Write a program to swap the values of two variables.
                    </button>
                </h2>
                <div id="collapseSeven" class="accordion-collapse collapse" aria-labelledby="headingSeven" data-bs-parent="#programAccordion">
                    <div class="accordion-body">
                        <pre>
#include &lt;iostream&gt;
using namespace std;

int main() {
    int a, b, temp;
    cout &lt;&lt; "\nEnter two numbers : ";
    cin &gt;&gt; a &gt;&gt; b;
    temp = a;
    a = b;
    b = temp;
    cout &lt;&lt; "\nAfter swapping numbers are : " &lt;&lt; a &lt;&lt; " " &lt;&lt; b;
    return 0;
}
                        </pre>
                    </div>
                </div>
            </div>

            <!-- Program 8 -->
            <div class="accordion-item">
                <h2 class="accordion-header" id="headingEight">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseEight" aria-expanded="false" aria-controls="collapseEight">
                        8. Write a program to calculate the area of a circle.
                    </button>
                </h2>
                <div id="collapseEight" class="accordion-collapse collapse" aria-labelledby="headingEight" data-bs-parent="#programAccordion">
                    <div class="accordion-body">
                        <pre>
#include &lt;iostream&gt;
using namespace std;

int main() {
    float r, area;
    cout &lt;&lt; "\nEnter radius of circle : ";
    cin &gt;&gt; r;
    area = 3.14 * r * r;
    cout &lt;&lt; "Area of circle : " &lt;&lt; area;
    return 0;
}
                        </pre>
                    </div>
                </div>
            </div>

            <!-- Program 9 -->
            <div class="accordion-item">
                <h2 class="accordion-header" id="headingNine">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseNine" aria-expanded="false" aria-controls="collapseNine">
                        9. Write a program to check whether a number is positive or negative (using ?: operator).
                    </button>
                </h2>
                <div id="collapseNine" class="accordion-collapse collapse" aria-labelledby="headingNine" data-bs-parent="#programAccordion">
                    <div class="accordion-body">
                        <pre>
#include &lt;iostream&gt;
using namespace std;

int main() {
    int a;
    cout &lt;&lt; "Enter any non-zero Number : ";
    cin &gt;&gt; a;
    (a &gt; 0) ? cout &lt;&lt; "Number is positive" : cout &lt;&lt; "Number is negative";
    return 0;
}
                        </pre>
                    </div>
                </div>
            </div>

            <!-- Program 10 -->
            <div class="accordion-item">
                <h2 class="accordion-header" id="headingTen">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTen" aria-expanded="false" aria-controls="collapseTen">
                        10. Write a program to check whether a number is even or odd (using ?: operator).
                    </button>
                </h2>
                <div id="collapseTen" class="accordion-collapse collapse" aria-labelledby="headingTen" data-bs-parent="#programAccordion">
                    <div class="accordion-body">
                        <pre>
#include &lt;iostream&gt;
using namespace std;

int main() {
    int a;
    cout &lt;&lt; "Enter the Number : ";
    cin &gt;&gt; a;
    (a % 2 == 0) ? cout &lt;&lt; "Number is even" : cout &lt;&lt; "Number is odd";
    return 0;
}
                        </pre>
                    </div>
                </div>
            </div>


        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
