import { ChangeDetectorRef, Component, OnInit, ViewChild } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { Injectable } from '@angular/core';
import { DeleteButtonCellRendererComponentComponent } from './delete-button-cell-renderer-component/delete-button-cell-renderer-component.component';
import { CommonService } from 'src/app/services/common.service';
import { AgGridAngular } from 'ag-grid-angular';
import { GridApi, GridReadyEvent } from 'ag-grid-community';
import { ColDef } from 'ag-grid-community';
import { Router } from '@angular/router';
 
   
@Component({
  selector: 'app-person',
  templateUrl: './person.component.html',
  styleUrls: ['./person.component.css']
})
export class PersonComponent implements OnInit {
  rowData: any[] = [];
  CustomerData:any;
  gridApi: any;
  gridColumnApi: any;
  context: any = {};
  inputRow = {};
  @ViewChild('agGrid') agGrid: AgGridAngular | undefined;

  constructor(public http: HttpClient, private router: Router, public commonservice: CommonService, private cdr: ChangeDetectorRef) { }
  

  // ag grid option setup 
  gridOptions = {
    rowData: [],
    defaultColDef: {
      editable: true,
      sortable: true,
      filter: true
    },
   onCellValueChanged: this.onCellValueChanged,
     pinnedTopRowData: [this.inputRow],
  };  
    
 // header column setting
  columnDefs: ColDef[] =[
    { headerName: 'id', field: 'id', editable: false },
    { headerName: 'name', field: 'name' },
    { headerName: 'state', field: 'state' },
    { headerName: 'zip', field: 'zip' },
    { headerName: 'amount', field: 'amount' },
    { headerName: 'qty', field: 'qty' },
    { headerName: 'item', field: 'item' },
    {
      headerName: 'Delete',
      cellRenderer: 'deleteButtonCellRenderer',
      maxWidth: 100,
      editable: false
    }
  ]  

  //  Rendered delete button call delete button component
  frameworkComponents = {
    deleteButtonCellRenderer: DeleteButtonCellRendererComponentComponent,
  };
  


  /// on grid load then ai call   
  onGridReady(params: any) {
    this.gridApi = params.api;
    this.gridColumnApi = params.columnApi;
}

      // Ag grid cell value change event  
      onCellValueChanged(event: any) { 
      if (event.data.hasOwnProperty('id')) {
      this.commonservice.updatedetails(event.data).subscribe(res=>{
      console.log('API response:', res);
      }, (error) => {
      console.error('API error:', error);
      });
      } else {
      this.commonservice.postdetails(event.data).subscribe(res=>{
      console.log('API response:', res);
      if(res){
      document.location.reload();
      this.cdr.detectChanges(); 
      // this.router.navigateByUrl('/person');
      }            
      }, (error) => {
      console.error('API error:', error);
      });
      }   
    }

   //Get all data   
  ngOnInit() {    
    this.context.createFn = async () => 1;  
    this.commonservice.Getalldata().subscribe((result) => {
      this.CustomerData=result;
      this.rowData=this.CustomerData.data;
    });
  }
  
}

