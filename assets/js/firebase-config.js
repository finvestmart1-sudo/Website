/* ============================================================
   FINVESTMART – FIREBASE CONFIGURATION
   ============================================================
   HOW TO SET UP (one-time, 5 minutes):
   1. Go to https://console.firebase.google.com
   2. Click "Add project" → name it "Finvestmart" → Continue
   3. Disable Google Analytics (optional) → Create project
   4. Click "Web" icon (</>) to add a web app → Register app
   5. Copy the firebaseConfig object values below
   6. In Firebase Console → Authentication → Get started
      → Enable "Email/Password" and "Google" sign-in methods
   7. In Firebase Console → Firestore Database → Create database
      → Start in "test mode" → Choose region → Done
   ============================================================ */

import { initializeApp } from "https://www.gstatic.com/firebasejs/10.12.0/firebase-app.js";
import { getAuth, GoogleAuthProvider } from "https://www.gstatic.com/firebasejs/10.12.0/firebase-auth.js";
import { getFirestore } from "https://www.gstatic.com/firebasejs/10.12.0/firebase-firestore.js";

// ▼▼▼ PASTE YOUR FIREBASE CONFIG HERE ▼▼▼
const firebaseConfig = {
  apiKey:            "YOUR_API_KEY",
  authDomain:        "YOUR_PROJECT_ID.firebaseapp.com",
  projectId:         "YOUR_PROJECT_ID",
  storageBucket:     "YOUR_PROJECT_ID.appspot.com",
  messagingSenderId: "YOUR_SENDER_ID",
  appId:             "YOUR_APP_ID"
};
// ▲▲▲ END OF CONFIG ▲▲▲

const app      = initializeApp(firebaseConfig);
const auth     = getAuth(app);
const db       = getFirestore(app);
const provider = new GoogleAuthProvider();

export { auth, db, provider };
