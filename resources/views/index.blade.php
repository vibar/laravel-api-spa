@extends('layouts.app')

@section('content')
<div class="container">
    <div class="justify-content-center">
        <div class="card">
            <div class="card-header">
                <h5 class="align-middle float-left mb-0" style="line-height: 2.1;">Propriedades</h5>
                <div class="btn-group float-right" role="group">
                    <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
                        Adicionar
                    </button>
                    <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                        <a class="dropdown-item" href="#" data-toggle="modal" data-target="#propertyAddModal">Propriedade</a>
                        <a class="dropdown-item" href="#" data-toggle="modal" data-target="#contractModal">Contrato</a>
                    </div>
                </div>
            </div>

            <div class="card-body">
                <table class="table table-condensed table-hover">
                    <thead>
                    <tr>
                        <td class="border-top-0 font-weight-bold"><a href="">E-mail</a></td>
                        <td class="border-top-0 font-weight-bold"><a href="">Endereço</a></td>
                        <td class="border-top-0 font-weight-bold"><a href="">Status</a></td>
                        <td class="border-top-0 font-weight-bold"></td>
                    </tr>
                    </thead>
                    <tr>
                        <td>email@gmail.com</td>
                        <td>Endereço 2</td>
                        <td>
                            <a href="#" class="badge badge-success p-2" data-toggle="modal" data-target="#contractModal">CONTRATADO</a>
                        </td>
                        <td>
                            <a href="#" class="close btn btn-sm btn-secondary text-white" data-toggle="modal" data-target="#propertyRemoveModal">
                                <span>&times;</span>
                            </a>
                        </td>
                    </tr>
                    <tr>
                        <td>email2@gmail.com</td>
                        <td>Endereço 1</td>
                        <td>
                            <a href="#" class="badge badge-danger p-2" data-toggle="modal" data-target="#contractModal">NÃO CONTRATADO</a>
                        </td>
                        <td>
                            <a href="#" class="close btn btn-sm btn-secondary text-white" data-toggle="modal" data-target="#propertyRemoveModal">
                                <span>&times;</span>
                            </a>
                        </td>
                    </tr>
                </table>
            </div>

            <!-- Modal -->
            <div class="modal fade" id="propertyAddModal" tabindex="-1" role="dialog">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Nova propriedade</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form>
                                <div class="row">
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label>E-mail <span class="text-danger">*</span></label>
                                            <input type="email" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label>Estado <span class="text-danger">*</span></label>
                                            <select class="form-control">
                                                <option value="">São Paulo</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label>Cidade <span class="text-danger">*</span></label>
                                            <select class="form-control">
                                                <option value="">São Paulo</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label>Bairro <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label>Rua <span class="text-danger">*</span></label>
                                            <input type="email" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-3">
                                        <div class="form-group">
                                            <label>Número</label>
                                            <input type="text" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-3">
                                        <div class="form-group">
                                            <label>Complemento</label>
                                            <input type="text" class="form-control">
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-light" data-dismiss="modal">Cancelar</button>
                            <button type="button" class="btn btn-primary">Salvar</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Modal -->
            <div class="modal fade" id="propertyRemoveModal" tabindex="-1" role="dialog">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">
                                Deseja realmente remover esta propriedade?
                            </h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            Item XPTO
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-light" data-dismiss="modal">Cancelar</button>
                            <button type="button" class="btn btn-danger">Remover</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Modal -->
            <div class="modal fade" id="contractModal" tabindex="-1" role="dialog">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Novo contrato</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form>
                                <div class="form-group">
                                    <label>Propriedade <span class="text-danger">*</span></label>
                                    <select class="form-control">
                                        <option value="">Propriedade 1</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Tipo <span class="text-danger">*</span></label>
                                    <select class="form-control">
                                        <option value="">Pessoa física</option>
                                        <option value="">Pessoa jurídica</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Documento <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label>E-mail <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label>Nome <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control">
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-light" data-dismiss="modal">Cancelar</button>
                            <button type="button" class="btn btn-primary">Salvar</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
