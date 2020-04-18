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

  judge_id: string = "";

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

  async tryLogin() {
    if (this.judge_id == ""){
      this.presentToast('Judge ID is required!')
    }
    else {
      const loader = await this.loadingCtrl.create({
        message: 'Please wait...',
      });
      loader.present();

      return new Promise(resolve=> {
        let body = {
          aksi: 'process_login',
          judge_id: this.judge_id
        }

        this.accsPrvds.postData(body, 'process_api.php').subscribe((res:any)=>{
          if(res.success == true){
            loader.dismiss();
            this.presentToast('Successfully logged in!');
            this.storage.set('storage_xxx', res.result); // create storage session
            this.navCtrl.navigateRoot(['/home']);
          }
          else {
            loader.dismiss();
            this.presentToast('Judge ID is unavailable!');
          }
        },(err)=>{
          loader.dismiss();
          this.presentToast('Login Timeout!');
        })
      });
    }
  }

  async presentToast(msg) {
    const toast = await this.toastCtrl.create({
      message: msg,
      duration: 1500,
      position: 'bottom'
    });
    toast.present();
  }

}
