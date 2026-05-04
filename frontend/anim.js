  
  // loader function script
window.addEventListener("load", function () {
  const loader = document.getElementById("loader");

  if (!sessionStorage.getItem("loaderShown")) {
   
    loader.style.display = "flex";

    setTimeout(() => {
      loader.style.display = "none";
      sessionStorage.setItem("loaderShown", "true"); 
    }, 2000); 
  } else {
    loader.style.display = "none";
  }
});


// script for scroll bar changing when scrolled


window.addEventListener("scroll", () => {
  console.log("scrolling", window.scrollY);

  if (window.scrollY > 200) {
    navbar.classList.add("scrolled");
  } else {
    navbar.classList.remove("scrolled");
  }
});

const navbar = document.querySelector(".navbar");

const logo = document.querySelector(".nav-logo");

const img1 = "mascot3.png";
const img2 = "mascot4.png";

// blinking effect (makes the mascot feel real)
function getRandomDelay() {
  // random interval between 5 and 10 sec
  const min = 5000;
  const max = 10000;
  
  return 5000 + Math.random() * 5000; // gets a random value (between 5s and 10s)

}

function blinkMascot() {
  logo.src = img2;

  setTimeout(() => {
    logo.src = img1;

    // random interval for blink
    const nextDelay = getRandomDelay();
    setTimeout(blinkMascot, nextDelay);
  }, 700);
}

// start first blink after a random delay
setTimeout(blinkMascot, getRandomDelay());


// this bit of code is for the mascot to 'read' out the navbar buttons

const bubble = document.getElementById("speech-bubble")

const messages = {
  "sidebar-btn": "Explore the lessons and quizzes!",
  "home-btn": "Home Page! Duh!",
  "about-btn": "Learn all about me and this website!",
  "signup-btn": "Get started! Make an account!",
  "signin-btn": "Signed up already? Jump back in!"
};

let typingInterval;

function typeText(text) {
  let i = 0;
  bubble.textContent = "";

  clearInterval(typingInterval);

  typingInterval = setInterval(() => {
    bubble.textContent += text.charAt(i);
    i++;

    if (i >= text.length) {
      clearInterval(typingInterval);
    }
  }, 25);
}

document.querySelectorAll(".btn").forEach(button => {
  button.addEventListener("mouseenter", () => {
    const text = messages[button.id];

    bubble.classList.add("show");
    typeText(text);
  });
  button.addEventListener("mouseleave", () => {
    bubble.classList.remove("show");
    clearInterval(typingInterval);
  })
})

// code for sidebar button to open
const menuBtn = document.getElementById("sidebar-btn");
const submenu = document.getElementById("sidebar");

menuBtn.addEventListener("click", () => {
  submenu.classList.toggle("open");
});
document.querySelectorAll(".section-title").forEach(title => {
  title.addEventListener("click", () => {
    const section = title.parentElement;
    section.classList.toggle("open");
  });
});


// signup/login form
function openAuth() {
  document.getElementById("authModal").classList.add("show");
}

function closeAuth() {
  document.getElementById("authModal").classList.remove("show");
}

function showLogin() {
  document.getElementById("loginForm").style.display = "block";
  document.getElementById("signupForm").style.display = "none";
}

function showSignup() {
  document.getElementById("loginForm").style.display = "none";
  document.getElementById("signupForm").style.display = "block";
}
window.addEventListener("click", function(e) {
  const modal = document.getElementById("authModal");
  const box = document.querySelector(".auth-box");

  if (e.target === modal) {
    closeAuth();
  }
});