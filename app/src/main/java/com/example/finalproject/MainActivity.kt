package com.example.finalproject

import android.annotation.SuppressLint
import android.os.Bundle
import android.webkit.WebChromeClient // IMPORT ADDED HERE
import android.webkit.WebSettings
import android.webkit.WebView
import android.webkit.WebViewClient
import androidx.activity.ComponentActivity
import androidx.activity.OnBackPressedCallback

class MainActivity : ComponentActivity() {

    private lateinit var webView: WebView

    @SuppressLint("SetJavaScriptEnabled")
    override fun onCreate(savedInstanceState: Bundle?) {
        super.onCreate(savedInstanceState)
        // Link to the XML layout we created
        setContentView(R.layout.activity_main)

        // Find the WebView from the layout
        webView = findViewById(R.id.webView)

        // Enable JavaScript (Required for your UI)
        val webSettings: WebSettings = webView.settings
        webSettings.javaScriptEnabled = true
        webSettings.domStorageEnabled = true // For LocalStorage
        webSettings.allowFileAccess = true
        // Enable Mixed Content (Helps if images are HTTP but app is HTTPS)
        webSettings.mixedContentMode = WebSettings.MIXED_CONTENT_ALWAYS_ALLOW

        // Ensure links open inside the app, not Chrome
        webView.webViewClient = WebViewClient()

        // 1. THIS IS THE NEW LINE THAT FIXES THE ALERTS!
        webView.webChromeClient = WebChromeClient()

        // Load the HTML file from the assets folder
        webView.loadUrl("file:///android_asset/index.html")

        // Handle back button presses using the modern OnBackPressedDispatcher
        onBackPressedDispatcher.addCallback(this, object : OnBackPressedCallback(true) {
            override fun handleOnBackPressed() {
                if (webView.canGoBack()) {
                    webView.goBack()
                } else {
                    // Disable this callback and call onBackPressed again to perform default action
                    isEnabled = false
                    onBackPressedDispatcher.onBackPressed()
                }
            }
        })
    }
}