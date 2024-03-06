import { mapGetters } from 'vuex'
export default {
    data() {
        return {
            key_station: '',
            loaderStatus: true,
            permission: null,
            userPermissio: null,
            isRead: false,
            isWrite: false,
            isEdit: false,
            isDelete: false,
            user: '',
            isReadUser: false,
            isReadFournisseur: false,
            isReadCommande: false,
            isReadProduit: false,
            isReadStock: false,
            isReadRole: false,
            isReadLigneVente: false,
            isReadAssign: false,
            isReadDepense: false,
            isReadHistoriqueVente: false,
        }
    },

    methods: {
        getRead() {
            axios.get('api/userBySession')
                .then(response => {
                    this.data = response.data.data

                    for (let p of this.data) {
                        if ('rapport' == p.name) {
                            if (p.read) {
                                this.isReadRapport = true
                                break
                            }
                        }
                    }

                    for (let p of this.data) {
                        if ('user' == p.name) {
                            if (p.read) {
                                this.isReadUser = true
                                break
                            }
                        }
                    }

                    for (let p of this.data) {
                        if ('bon-commande' == p.name) {
                            if (p.read) {
                                this.isReadCommande = true
                                break
                            }
                        }
                    }

                    for (let p of this.data) {
                        if ('fournisseur' == p.name) {
                            if (p.read) {
                                this.isReadFournisseur = true
                                break
                            }
                        }
                    }

                    for (let p of this.data) {
                        if ('produit' == p.name) {
                            if (p.read) {
                                this.isReadProduit = true
                                break
                            }
                        }
                    }

                    for (let p of this.data) {
                        if ('stock' == p.name) {
                            if (p.read) {
                                this.isReadStock = true
                                break
                            }
                        }
                    }

                    for (let p of this.data) {
                        if ('unite' == p.name) {
                            if (p.read) {
                                this.isReadUnite = true
                                break
                            }
                        }
                    }

                    for (let p of this.data) {
                        if ('categorie' == p.name) {
                            if (p.read) {
                                this.isReadCategorie = true
                                break
                            }
                        }
                    }

                    for (let p of this.data) {
                        if ('ligne-vente' == p.name) {
                            if (p.read) {
                                this.isReadLigneVente = true
                                break
                            }
                        }
                    }

                    for (let p of this.data) {
                        if ('produit' == p.name) {
                            if (p.read) {
                                this.isReadProd = true
                                break
                            }
                        }
                    }

                    for (let p of this.data) {
                        if ('user' == p.name) {
                            if (p.read) {
                                this.isReadUser = true
                                break
                            }
                        }
                    }

                    for (let p of this.data) {
                        if ('role' == p.name) {
                            if (p.read) {
                                this.isReadRole = true
                                break
                            }
                        }
                    }

                    for (let p of this.data) {
                        if ('assign-role' == p.name) {
                            if (p.read) {
                                this.isReadAssign = true
                                break
                            }
                        }
                    }

                    for (let p of this.data) {
                        if ('historique-vente' == p.name) {
                            if (p.read) {
                                this.isReadHistoriqueVente = true
                                break
                            }
                        }
                    }

                    for (let p of this.data) {
                        if ('depense' == p.name) {
                            if (p.read) {
                                this.isReadDepense = true
                                break
                            }
                        }
                    }


                })
                .catch(error => {
                    if (error.response?.data?.message == 'Token has expired') {
                        this.$store.commit('logout');
                        this.$router.push('/login');
                    } else if (error.response?.data?.message == 'token Invalid') {
                        this.$store.commit('logout');
                        this.$router.push('/login');
                    } else if (error.response?.data?.message == 'token Not found') {
                        this.$store.commit('logout');
                        this.$router.push('/login');
                    }
                });
        },
        getRolePermission() {
            axios.get('api/userBySession')
                .then(response => {
                    this.permission = response.data.permission
                    this.user = response.data.user

                    for (let p of JSON.parse(this.permission)) {
                        if (this.$route.name == p.name) {
                            if (p.write) {
                                this.isWrite = true
                                break
                            }
                        }
                    }

                    for (let p of JSON.parse(this.permission)) {
                        if (this.$route.name == p.name) {
                            if (p.update) {
                                this.isEdit = true
                                break
                            }
                        }
                    }

                    for (let p of JSON.parse(this.permission)) {
                        if (this.$route.name == p.name) {
                            if (p.delete) {
                                this.isDelete = true
                                break
                            }
                        }
                    }
                })
                .catch(error => {
                    if (error.response?.data?.message == 'Token has expired') {
                        this.$store.commit('logout');
                        this.$router.push('/login');
                    } else if (error.response?.data?.message == 'token Invalid') {
                        this.$store.commit('logout');
                        this.$router.push('/login');
                    } else if (error.response?.data?.message == 'token Not found') {
                        this.$store.commit('logout');
                        this.$router.push('/login');
                    }
                });
        },
        showAlertError(msg) {
            this.$swal.fire({
                position: 'top-end',
                icon: 'error',
                toast: true,
                title: msg,
                showConfirmButton: false,
                timer: 5000
            })
        },
        showAlertInfo(msg) {
            this.$swal.fire({
                position: 'top-end',
                icon: 'info',
                toast: true,
                title: msg, //"Quelque chose s'est mal passé ! Veuillez réessayer.",
                showConfirmButton: false,
                timer: 3000
            })
        },
        showAlertSuccess(msg) {
            this.$swal.fire({
                position: 'top-end',
                icon: 'success',
                toast: true,
                title: msg,
                showConfirmButton: false,
                timer: 3000
            })
        },

        async callApi(method, url, dataObj) {
            try {
                return await axios({
                    method: method,
                    url: url,
                    data: dataObj
                });
            } catch (e) {
                return e.response
            }
        },

        i(desc, title = "Hey") {
            this.$Notice.info({
                title: title,
                desc: desc
            });
        },
        s(desc, title = "Great!") {
            this.$Notice.success({
                title: title,
                desc: desc
            });
        },
        w(desc, title = "Oops!") {
            this.$Notice.warning({
                title: title,
                desc: desc
            });
        },
        e(desc, title = "Oops!") {
            this.$Notice.error({
                title: title,
                desc: desc
            });
        },
        swr(desc = "Quelque chose s'est mal passé ! Veuillez réessayer.", title = "Oops") {
            this.$Notice.error({
                title: title,
                desc: desc
            });
        },
    },


}
