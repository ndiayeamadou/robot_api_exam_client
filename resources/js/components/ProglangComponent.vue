<template>
    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-md-2">
                    <h6>Programming Languages</h6>
                </div>
                <div class="col-md-6">
                </div>
                <div class="col-md-4">
                    <button disabled type="button" data-toggle="modal" data-target="#exampleModal" class="btn btn-primary"><i class="fa fa-plus"></i>Add a programming language</button>
                </div>
            </div>
        </div>

        <div class="card-body" style="background-color: #343535; color: white;">
            <div v-if="loading" class="text-warning text-center"><b>loading...</b></div>
            <div class="table-responsive" v-else>
                <table
                    class="table table-hover table-bordered table-striped table-dark"
                    id="proglangdtable"
                >
                    <thead>
                        <tr>
                            <th>Code</th>
                            <th>DisplayName</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="proglanguage in proglanguages">
                            <td>{{ proglanguage.code }}</td>
                            <td>{{ proglanguage.displayName }}</td>
                            <td>
                                <button disabled class="btn btn-info btn-sm" type="button" title="voir les détails"><i class="fas fa-eye"></i></button>
                                <button disabled class="btn btn-primary btn-sm" type="button" title="éditer"><i class="fas fa-edit"></i></button>
                                <button disabled class="btn btn-danger btn-sm" type="button" title="supprimer"><i class="fas fa-trash"></i></button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</template>

<script>
import datatable from "datatables.net-bs4";
require('datatables.net-buttons/js/dataTables.buttons')
require('datatables.net-buttons/js/buttons.html5')
import print from 'datatables.net-buttons/js/buttons.print'
import jszip from 'jszip/dist/jszip'
import pdfMake from "pdfmake/build/pdfmake"
import pdfFonts from "pdfmake/build/vfs_fonts"
pdfMake.vfs = pdfFonts.pdfMake.vfs;
//for excel button --- to work
window.JSZip = jszip
import swal from 'sweetalert'
export default {
    mounted() {
        this.loadProglanguages();
    },

    data: function() {
        return {
            proglanguages: [],
            loading: true
        };
    },
    methods: {
        produtsTable() {
            this.$nextTick(() => {
                $("#proglangdtable").DataTable({
                    "order": [0,'desc'],
                    //dom: 'lBfrtip',
                    dom: "<'row'<'col-sm-12 mb-3 text-center'B>>" +
                        "<'row'<'col-sm-12 col-md-6'l><'col-sm-12 col-md-6'f>>" +
                        "<'row'<'col-sm-12'tr>>" +
                        "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
                    buttons: [
                        //'copy', 'excel', 'pdf'
                        {
                            "extend": "copyHtml5",
                            "text": "<i class='fas fa-copy'></i> Copier",
                            "titleAttr": "Copier",
                            'className': "btn btn-secondary",
                            exportOptions: {
                                columns: [0, 1]
                            }
                        },
                        {
                            "extend": "excelHtml5",
                            "text": "<i class='fas fa-file-excel'></i> Exporter",
                            "titleAttr": "Exporter en tant que fichier excel",
                            'className': "btn btn-success",
                            exportOptions: {
                                columns: [0, 1]
                            }
                        },
                        {
                            "extend": "pdfHtml5",
                            "text": "<i class='fas fa-file-pdf'></i> PDF",
                            "titleAttr": "Exporter en tant que fichier pdf",
                            'className': "btn btn-danger",
                            exportOptions: {
                                columns: [0, 1]
                            }
                        },
                        {
                            "extend": "csvHtml5",
                            "text": "<i class='fas fa-file-csv'></i> CSV",
                            "titleAttr": "Exporter en tant que fichier csv",
                            'className': "btn btn-success",
                            exportOptions: {
                                columns: [0, 1]
                            }
                        },
                        {
                            "extend": "print",
                            "text": "<i class='fas fa-file-excel'></i> Imprimer",
                            "titleAttr": "Imprimer",
                            'className': "btn btn-success",
                            exportOptions: {
                                columns: [0, 1]
                            }
                        }
                    ]
                });
            });
        },
        loadProglanguages() {
            axios
                .get("/api/planguages")
                .then(response => {
                    this.proglanguages = response.data
                    $('#proglangdtable').DataTable().destroy()
                    this.produtsTable()
                    this.loading = false
                })
                .catch(function(error) {
                    console.log(error);
                });
        },

    }
};
</script>
