import { Component } from '@angular/core';

import { Platform } from '@ionic/angular';
import { SplashScreen } from '@ionic-native/splash-screen/ngx';
import { StatusBar } from '@ionic-native/status-bar/ngx';
import { Storage } from "@ionic/storage";
import { NavController } from "@ionic/angular";
import { Router } from '@angular/router';

@Component({
  selector: 'app-root',
  templateUrl: 'app.component.html',
  styleUrls: ['app.component.scss']
})
export class AppComponent {
  constructor(
    private platform: Platform,
    private splashScreen: SplashScreen,
    private statusBar: StatusBar,
    private storage: Storage,
    public navCtrl: NavController,
    private router: Router
  ) {
    this.initializeApp();
  }

  ngOnInit() {
    this.platform.backButton.subscribeWithPriority(0, () => {
      if (this.router.url === '/home' || this.router.url === '/login') {
        navigator['app'].exitApp();
      }  else {
       this.navCtrl.back();
      }
    });
  }

  initializeApp() {
    this.platform.ready().then(() => {
      this.statusBar.styleLightContent();
      this.splashScreen.hide();
    });

    this.storage.get('storage_xxx').then((res)=>{
      if (res==null){
        this.navCtrl.navigateRoot('/login');
      }
      else{
        this.navCtrl.navigateRoot('/home');
      }
    })
  }
}
