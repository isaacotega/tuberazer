package com.ovolisky.tuberazer;

import android.app.*;
import android.os.*;
import android.app.Activity;
import android.content.Context;
import android.os.Bundle;
import android.view.KeyEvent;
import android.view.View;
import android.webkit.JavascriptInterface;
import android.webkit.WebSettings;
import android.webkit.WebView;
import android.webkit.WebViewClient;
import android.widget.Toast;
import android.net.Uri;


import android.app.Activity;
import android.app.DownloadManager;
import android.content.BroadcastReceiver;
import android.content.ComponentName;
import android.content.Context;
import android.content.Intent;
import android.content.pm.PackageManager;
import android.net.Uri;
import android.os.Build;
import android.os.Bundle;
import android.os.Environment;
import android.os.Parcelable;
import android.util.Log;
import android.view.View;
import android.webkit.DownloadListener;
import android.webkit.JavascriptInterface;
import android.webkit.JsResult;
import android.webkit.URLUtil;
import android.webkit.ValueCallback;
import android.webkit.WebBackForwardList;
import android.webkit.WebChromeClient;
import android.webkit.WebSettings;
import android.webkit.WebView;
import android.webkit.WebViewClient;
import android.widget.Toast;
import java.io.File;
import java.io.IOException;


import android.graphics.Bitmap;
import android.graphics.BitmapFactory;
import java.net.URL;
import android.content.ContextWrapper;


public class MainActivity extends Activity 
{
	
	private WebView webView;
	private long pressedTime;
	
    @Override
    protected void onCreate(Bundle savedInstanceState)
    {
        super.onCreate(savedInstanceState);
		
		if (savedInstanceState == null)
		{
       		
			setContentView(R.layout.main);
			
		}

		
		this.webView = (WebView)this.findViewById(R.id.mainWebview);
		WebSettings webSettings = this.webView.getSettings();
		webSettings.setJavaScriptEnabled(true);
		WebView webView = this.webView;
		WebViewClient webViewClient = new WebViewClient();
		webView.setWebViewClient(webViewClient);
		this.webView.loadUrl("file:///android_asset/splash.html");
		this.webView.getSettings().setCacheMode(2);
		webSettings.setUseWideViewPort(true);
		webSettings.setDomStorageEnabled(true);
		this.webView.setInitialScale(5);
		this.webView.addJavascriptInterface((Object)this, "Android");
		this.webView.setBackgroundColor(0);
        this.webView.getSettings().setTextZoom(100);
		
		webView.setWebViewClient(new WebViewClient() {

				WebView webView = (WebView) findViewById(R.id.mainWebview);
				
				@Override
				public void onReceivedError(WebView view, int errorCode, String description, String failingUrl) {

					webView.loadUrl("file:///android_asset/connection-error.html?next=" + failingUrl);

				}

			});
/*
		ContextWrapper c = new ContextWrapper(this);
		Toast.makeText(this, c.getFilesDir().getPath(), Toast.LENGTH_LONG).show();
*/

    }

		@Override
		public void onBackPressed() {

			if (pressedTime + 2000 > System.currentTimeMillis()) {
				super.onBackPressed();
				finish();
			} else {
				Toast.makeText(getBaseContext(), "Press back again to exit", Toast.LENGTH_SHORT).show();
			}
			pressedTime = System.currentTimeMillis();
		}

	@Override
	protected void onSaveInstanceState(Bundle outState )
	{
		super.onSaveInstanceState(outState);
		webView.saveState(outState);
	}

	@Override
	protected void onRestoreInstanceState(Bundle savedInstanceState)
	{
		super.onRestoreInstanceState(savedInstanceState);
		webView.restoreState(savedInstanceState);
	}
	
	

	
	@JavascriptInterface
	public boolean toast(String text) {
		Toast.makeText(getBaseContext(), text, Toast.LENGTH_SHORT).show();
		return true;
	}

	@JavascriptInterface
	public boolean notification(String title, String text) {

		Notification notification = new Notification.Builder(MainActivity.this)
			.setContentTitle(title)
			.setContentText(text)
			.setSmallIcon(R.drawable.app_icon)
			.build();  

		NotificationManager manager = (NotificationManager) getSystemService(Context.NOTIFICATION_SERVICE);
		manager.notify(0, notification);
		return true;
		
	}
	
	@JavascriptInterface
	public String version() {
		return "1.0";
	}
	
	
	// So, this is where you'll begin working on. 
	
	// this method below (publicDownload) will download the file from the url passed as the first argument and save it with the filename passed in the filename argument
	// It will return true on successful download and false on if any error occurs
	// Download will be done theough download manager

	@JavascriptInterface
	public boolean publicDownload(String url, String filename) {
		
		// temporary response
		return true;
		
	}
	

	// this method below (secretDownload) will download the file from the url passed as the first argument and save it with the filename passed in the filename argument
	// It will return true on successful download and false on if any error occurs
	// download will not be done through download manager and will be saved somewhere around sdcard0/data/com.ovolisky.tuberazer or so
	
	@JavascriptInterface
	public boolean secretDownload(String url, String filename) {

		// temporary response
		return true;

	}
	

	@JavascriptInterface
	public boolean imageNotification(String title, String text, String url) {
		
		// Na here gbege dey
		// I want to find a way to derive the bigImage variable from the result of url
		// the image shown in the notification will be gotten from the url

		int bigImage = 00000;
			
		
		NotificationManager manager = (NotificationManager) getSystemService(Context.NOTIFICATION_SERVICE);
		
		Intent notificationIntent = new Intent(MainActivity.this, MainActivity.class);
		notificationIntent.setFlags(Intent.FLAG_ACTIVITY_CLEAR_TOP
									| Intent.FLAG_ACTIVITY_SINGLE_TOP);
									
		PendingIntent intent =
			PendingIntent.getActivity(MainActivity.this, 0,
									  notificationIntent,PendingIntent.FLAG_UPDATE_CURRENT);
									  
		// big image will be used here below
								  
		Bitmap bitmap = BitmapFactory.decodeResource(getResources(), bigImage);
		
		int icon = R.drawable.app_icon;
		
		long when = System.currentTimeMillis();
		
		Notification notification = new Notification.Builder(MainActivity.this)
			.setContentTitle(title)
			.setContentText(text)
			.setContentIntent(intent)
			.setSmallIcon(icon)
			.setWhen(when)
			.setStyle(new Notification.BigPictureStyle()
					  .bigPicture(bitmap).setSummaryText(text))
			.build();
		notification.flags |= Notification.FLAG_AUTO_CANCEL;

		notification.defaults |= Notification.DEFAULT_SOUND;
		notification.defaults |= Notification.DEFAULT_VIBRATE;

		manager.notify(0, notification);
		
		return true;
		
	}
	
	// You can just create java methods and put the code inside for debugging purposes rather than the javascript interfaces
	
}

		/*
		Notification notification = new Notification.Builder(MainActivity.this)
			.setContentTitle("New Message")
			.setContentText("You've received new messages.")
			.setSmallIcon(R.drawable.app_icon)
			.build();  
			
		NotificationManager manager = (NotificationManager) getSystemService(Context.NOTIFICATION_SERVICE);
		manager.notify(0, notification);
		
		
		
		
		Intent notificationIntent = new Intent(MainActivity.this, MainActivity.class);
notificationIntent.setFlags(Intent.FLAG_ACTIVITY_CLEAR_TOP
| Intent.FLAG_ACTIVITY_SINGLE_TOP);
PendingIntent intent =
			PendingIntent.getActivity(MainActivity.this, 0,
notificationIntent,PendingIntent.FLAG_UPDATE_CURRENT);
Bitmap bitmap = BitmapFactory.decodeResource(getResources(),
R.drawable.app_icon);
String message="Hello Notification with image<br><br>a";
String title="Notification !!!";
int icon = R.drawable.app_icon;
long when = System.currentTimeMillis();
		notification = new Notification.Builder(MainActivity.this)
.setContentTitle(title)
.setContentText(message)
.setContentIntent(intent)
.setSmallIcon(icon)
.setWhen(when)
.setStyle(new Notification.BigPictureStyle()
.bigPicture(bitmap).setSummaryText(message))
.build();
notification.flags |= Notification.FLAG_AUTO_CANCEL;
// Play default notification sound
notification.defaults |= Notification.DEFAULT_SOUND;
notification.defaults |= Notification.DEFAULT_VIBRATE;

manager.notify(0, notification);


	public void downloadFile(URL url, String outputFileName) throws IOException {

        try (InputStream in = url.openStream();
		ReadableByteChannel rbc = Channels.newChannel(in);
		FileOutputStream fos = new FileOutputStream(outputFileName)) {
            fos.getChannel().transferFrom(rbc, 0, Long.MAX_VALUE);
        }
		// do your work here
		Toast.makeText(getApplicationContext(), (CharSequence)"Downloading...", (int)0).show();
    }
	
	
	public void onDownloadStart(String string2, String string3, String string4, String string5, long l) {
		Intent intent = new Intent("android.intent.action.VIEW");
		intent.setData(Uri.parse((String)string2));
		this.startActivity(intent);
		DownloadManager.Request request = new DownloadManager.Request(Uri.parse((String)string2));
		request.setTitle((CharSequence)URLUtil.guessFileName((String)string2, (String)string4, (String)string5));
		request.setDescription((CharSequence)"Downloading file...");
		request.setNotificationVisibility(1);
		request.setDestinationInExternalPublicDir(Environment.DIRECTORY_DOWNLOADS, URLUtil.guessFileName((String)string2, (String)string4, (String)string5));
		((DownloadManager)this.getSystemService("download")).enqueue(request);
		Toast.makeText((Context)this.getApplicationContext(), (CharSequence)"Downloading...", (int)0).show();
	}
	
	
		String url = webView.getUrl();
		
		if(webView.getUrl().contains("&downloadfile")) {
			DownloadManager.Request request = new DownloadManager.Request(
				Uri.parse(url));
			request.allowScanningByMediaScanner();
			request.setNotificationVisibility(DownloadManager.Request.VISIBILITY_VISIBLE_NOTIFY_COMPLETED);
			request.setDestinationInExternalPublicDir(Environment.DIRECTORY_DOWNLOADS, "download"); 
// You can change the name of the downloads, by changing "download" to everything you want, such as the mWebview title...
			DownloadManager dm = (DownloadManager) getSystemService(DOWNLOAD_SERVICE);
			dm.enqueue(request);        

			Toast.makeText(getBaseContext(), "Downloading", Toast.LENGTH_SHORT).show();
			
		}
		
		
		webView.setDownloadListener(new DownloadListener() {

				@Override
				public void onDownloadStart(String url, String userAgent, String contentDisposition
											, String mimetype, long contentLength) {

					String fileName = URLUtil.guessFileName(url, contentDisposition, mimetype);

					try {
						String address = Environment.getExternalStorageDirectory().getAbsolutePath() + "/"
                            + Environment.DIRECTORY_DOWNLOADS + "/" +
                            fileName;
						File file = new File(address);
						boolean a = file.createNewFile();

						URL link = new URL(url);
						downloadFile(link, address);

					} catch (Exception e) {
						e.printStackTrace();
					}
				}
			});

	
		
		webView.setDownloadListener(new DownloadListener() {
				
				@Override
				public void onDownloadStart(String url, String userAgent,
											String contentDisposition, String mimetype,
											long contentLength) {
					DownloadManager.Request request = new DownloadManager.Request(
						Uri.parse(url));

					request.allowScanningByMediaScanner();
					request.setNotificationVisibility(DownloadManager.Request.VISIBILITY_VISIBLE_NOTIFY_COMPLETED); //Notify client once download is completed!
					request.setDestinationInExternalPublicDir(Environment.DIRECTORY_DOWNLOADS, "Name of your downloadble file goes here, example: Mathematics II ");
					DownloadManager dm = (DownloadManager) getSystemService(DOWNLOAD_SERVICE);
					dm.enqueue(request);
					Toast.makeText(getApplicationContext(), "Downloading File", //To notify the Client that the file is being downloaded
								   Toast.LENGTH_LONG).show();

				}
			});
			
*/


