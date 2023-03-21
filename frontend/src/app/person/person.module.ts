import { NgModule } from '@angular/core';
import { BrowserModule } from '@angular/platform-browser';
import { HttpClientModule } from '@angular/common/http';
import { AppRoutingModule } from '../app-routing.module';
import { AppComponent } from '../app.component';
import { PersonComponent } from '../person/person.component';
import { AppSettingService } from '../services/appSettings.service';
import { AgGridModule } from 'ag-grid-angular';
import { GridApi, GridReadyEvent } from 'ag-grid-community';
import { CommonService } from 'src/app/services/common.service';
import { Router } from '@angular/router';  

import { DeleteButtonCellRendererComponentComponent } from './delete-button-cell-renderer-component/delete-button-cell-renderer-component.component';
@NgModule({    
  declarations: [
    AppComponent,
    PersonComponent,
    DeleteButtonCellRendererComponentComponent
  ],
  imports: [
    BrowserModule,
    AppRoutingModule,
    HttpClientModule,
    AgGridModule,
    Router
  ],
  providers: [AppSettingService, CommonService],
  bootstrap: [AppComponent]
})
export class AppModule { }
