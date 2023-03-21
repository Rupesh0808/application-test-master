import { Component, OnInit } from '@angular/core';
import { ICellRendererAngularComp } from 'ag-grid-angular';
import { ICellRendererParams } from 'ag-grid-community';
import { CommonService } from 'src/app/services/common.service';
@Component({
  selector: 'app-delete-button-cell-renderer-component',
  templateUrl: './delete-button-cell-renderer-component.component.html',
  styleUrls: ['./delete-button-cell-renderer-component.component.css']
})
export class DeleteButtonCellRendererComponentComponent implements ICellRendererAngularComp  {
  params: any;

  constructor(public commonservice:CommonService) { }
  agInit(params: any): void {
    this.params = params;
  } 

  refresh(params: any): boolean {
    return true;
  }
 
  // Delete button click 
  onClick(): void {
     const idds  = this.params.data.id;
   for (let key in this.params.data) {
    // If the key is not "id", remove it from the object
    if (key !== 'id') {
      delete this.params.data[key];
    }
  }

  /// Delete api call 
     this.commonservice.deleteUser(this.params.data).subscribe((response: any) => {
        console.log("RRRRR", response);
        if(response){
          document.location.reload();
        }
      }, (error: any) => {
        console.log("GGGG", error);
      });
  }   

  ngOnInit(): void {
  }

}
