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

import { initializeApp, getApps, getApp } from "https://www.gstatic.com/firebasejs/10.12.0/firebase-app.js";
import { getAuth, GoogleAuthProvider } from "https://www.gstatic.com/firebasejs/10.12.0/firebase-auth.js";
import { getFirestore } from "https://www.gstatic.com/firebasejs/10.12.0/firebase-firestore.js";

// ▼▼▼ PASTE YOUR FIREBASE CONFIG HERE ▼▼▼
const firebaseConfig = {
  apiKey:            "AIzaSyAENzxQxUZKyoHon049Swm5Xby3Xn-TUv4",
  authDomain:        "finvestmart-ddb3e.firebaseapp.com",
  projectId:         "finvestmart-ddb3e",
  storageBucket:     "finvestmart-ddb3e.firebasestorage.app",
  messagingSenderId: "237870571612",
  appId:             "1:237870571612:web:48a02f3213fb1f27370699",
  measurementId:     "G-QWS4D61W3H"
};
// ▲▲▲ END OF CONFIG ▲▲▲

// Re-use the existing app if already initialized (prevents duplicate-app error)
const app      = getApps().length ? getApp() : initializeApp(firebaseConfig);
const auth     = getAuth(app);
const db       = getFirestore(app);
const provider = new GoogleAuthProvider();

export { auth, db, provider };
