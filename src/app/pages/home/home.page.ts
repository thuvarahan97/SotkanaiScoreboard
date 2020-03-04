import { Component, OnInit } from '@angular/core';
import { Router, ActivatedRoute } from '@angular/router';
import { ToastController, LoadingController, AlertController, NavController } from "@ionic/angular";
import { AccessProviders } from "../../providers/access-providers";
import { Storage } from "@ionic/storage";

@Component({
  selector: 'app-home',
  templateUrl: './home.page.html',
  styleUrls: ['./home.page.scss'],
})
export class HomePage implements OnInit {

  datastorage: any;
  name: string;

  panel_id: string = "";

  disabledButton;

  constructor(
    private router: Router,
    private toastCtrl: ToastController,
    private loadingCtrl: LoadingController,
    private alertCtrl: AlertController,
    private navCtrl: NavController,
    private accsPrvds: AccessProviders,
    private storage: Storage
  ) { }

  ngOnInit() {
  }
  
  ionViewDidEnter() {
    this.storage.get('storage_xxx').then((res)=>{
      console.log(res);
      this.datastorage = res;
      this.name = this.datastorage.your_name
      this.disabledButton = false;
    });
  }

  async processLogout() {
    this.storage.clear();
    this.navCtrl.navigateRoot(['/login']);
    this.presentToast('Successfully logged out!');
  }

  async selectPanel() {
    if (this.panel_id == ""){
      this.presentToast('Select a panel to continue!')
    }
    else {
      const loader = await this.loadingCtrl.create({
        message: 'Please wait......',
      });
      loader.present();

      return new Promise(resolve=> {
        let body = {
          aksi: 'select_panel',
          panel_id: this.panel_id
        }

        this.accsPrvds.postData(body, 'process_api.php').subscribe((res:any)=>{
          if(res.success == true){
            loader.dismiss();
            this.disabledButton = false;
            this.storage.set('storage_xxx', res.result); // create storage session
            this.navCtrl.navigateRoot(['/home']);
          }
          else {
            loader.dismiss();
            this.disabledButton = false;
            this.presentToast('Panel is currently unavailable!');
          }
        },(err)=>{
          loader.dismiss();
          this.disabledButton = false;
          this.presentToast('Timeout!');
        })
      });
    }
  }

  async presentToast(a) {
    const toast = await this.toastCtrl.create({
      message: a,
      duration: 1500,
      position: 'top'
    });
    toast.present();
  }

}
