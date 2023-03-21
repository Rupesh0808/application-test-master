import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { Observable } from 'rxjs';
import { Datatype } from '../shared/datatype';
import { AppSettingService } from './appSettings.service';  

@Injectable({  
  providedIn: 'root'
})
export class CommonService {

  //Get common url for api call
  Url =  this.appSettings.devWebAPI_URL;


  constructor(private http:HttpClient, private appSettings:AppSettingService) { }

  // Get Data
  Getalldata():Observable<Datatype[]>
  {
      return this.http.get<Datatype[]>(this.Url);
  }   


// Update Data
  updatedetails(persondata: any){
    return this.http.post(this.Url,persondata);
  }

// Post Data
  postdetails(personinsert: any){
    return this.http.post(this.Url,personinsert);
  }

// Delete Data
  deleteUser(prsn:any){
    console.log("delet", prsn);
    
    return this.http.post(this.Url,prsn);
  }
 
  
}
