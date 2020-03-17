import { Component, OnInit } from '@angular/core';
import { Router, ActivatedRoute } from '@angular/router';
import { ToastController, LoadingController, AlertController, NavController } from "@ionic/angular";
import { AccessProviders } from "../../providers/access-providers";
import { Storage } from "@ionic/storage";
import { ScreenOrientation } from '@ionic-native/screen-orientation/ngx';

@Component({
  selector: 'app-login',
  templateUrl: './login.page.html',
  styleUrls: ['./login.page.scss'],
})
export class LoginPage implements OnInit {

  user_id: string = "";

  disabledButton;

  constructor(
    private router: Router,
    private toastCtrl: ToastController,
    private loadingCtrl: LoadingController,
    private alertCtrl: AlertController,
    private navCtrl: NavController,
    private accsPrvds: AccessProviders,
    private storage: Storage,
    private screenOrientation: ScreenOrientation
  ) {
    // set screen orientation to portrait
    this.screenOrientation.lock(this.screenOrientation.ORIENTATIONS.PORTRAIT);
  }

  ngOnInit() {
  }

  ionViewDidEnter() {
    this.disabledButton = false;
  }

  async tryLogin() {
    if (this.user_id == ""){
      this.presentToast('User ID is required!')
    }
    else {
      this.disabledButton = true;
      const loader = await this.loadingCtrl.create({
        message: 'Please wait...',
      });
      loader.present();

      return new Promise(resolve=> {
        let body = {
          aksi: 'process_login',
          user_id: this.user_id
        }

        this.accsPrvds.postData(body, 'process_api.php').subscribe((res:any)=>{
          if(res.success == true){
            loader.dismiss();
            this.disabledButton = false;
            this.presentToast('Successfully logged in!');
            this.storage.set('storage_xxx', res.result); // create storage session
            this.navCtrl.navigateRoot(['/home']);
          }
          else {
            loader.dismiss();
            this.disabledButton = false;
            this.presentToast('User ID is unavailable!');
          }
        },(err)=>{
          loader.dismiss();
          this.disabledButton = false;
          this.presentToast('Login Timeout!');
        })
      });
    }
  }

  async presentToast(a) {
    const toast = await this.toastCtrl.create({
      message: a,
      duration: 1500,
      position: 'bottom'
    });
    toast.present();
  }

}
