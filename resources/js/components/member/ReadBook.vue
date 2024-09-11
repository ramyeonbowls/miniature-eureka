<template>
    <section class="section">
        <div class="row">
            <div class="col-12 col-lg-4">
                <div class="card">
                    <div class="d-flex justify-content-center align-items-center flex-column">
                        <div class="card-content">
                            <img src="images/cover/202311230610-1700719846-5 Manfaat Daun Pandan yang Populer di Masyarakat.jpg" class="card-img-center img-fluid" alt="singleminded">
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-8">
                <div class="card">
                    <div class="card-header">
                        <p class="text-subtitle text-muted">Nisa Amalia</p>
                        <h3 class="mt-1">5 Manfaat Daun Pandan yang Populer di Masyarakat</h3>
                    </div>
                    <div class="card-body">
                        <div class="divider divider-left">
                            <div class="divider-text">Deskripsi Buku</div>
                        </div>
                        <p class="my-2">
                            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla ut nulla neque. Ut hendrerit nulla a euismod pretium. Fusce venenatis sagittis ex efficitur suscipit. In tempor mattis fringilla. Sed id tincidunt orci, et volutpat ligula. Aliquam sollicitudin sagittis ex, a rhoncus nisl feugiat quis. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc ultricies ligula a tempor vulputate. Suspendisse pretium mollis ultrices.
                            <div class="collapse" id="collapseExample">
                                Integer interdum diam eleifend metus lacinia, quis gravida eros mollis. Fusce non sapien sit amet magna dapibus ultrices. Morbi tincidunt magna ex, eget faucibus sapien bibendum non. Duis a mauris ex. Ut finibus risus sed massa mattis porta. Aliquam sagittis massa et purus efficitur ultricies. Integer pretium dolor at sapien laoreet ultricies. Fusce congue et lorem id convallis. Nulla volutpat tellus nec molestie finibus. In nec odio tincidunt eros finibus ullamcorper. Ut sodales, dui nec posuere finibus, nisl sem aliquam metus,eu accumsan lacus felis at odio. Sed lacus quam, convallis quis condimentum ut, accumsan congue massa. Pellentesque et quam vel massa pretium ullamcorper vitae eu tortor.
                            </div>
                        </p>
                        <a class="my-2 d-flex justify-content-end" data-bs-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample"  id="toggleDescription"> Baca Selengkapnya </a>
                        <div class="divider divider-left">
                            <div class="divider-text">Detail</div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-1 mt-0">
                                <div class="form-group">
                                    <div class="comment-body">
                                        <div class="comment-profileName mb-0">Stock </div>
                                        <div class="comment-time mt-0">2/2</div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="comment-body">
                                        <div class="comment-profileName mb-0">Jumlah Halaman </div>
                                        <div class="comment-time mt-0">72</div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="comment-body">
                                        <div class="comment-profileName mb-0">ISBN </div>
                                        <div class="comment-time mt-0">978-623-166-290-3</div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 mb-1 mt-0">
                                <div class="form-group">
                                    <div class="comment-body">
                                        <div class="comment-profileName mb-0">Penulis </div>
                                        <div class="comment-time mt-0">Nisa Amalia</div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="comment-body">
                                        <div class="comment-profileName mb-0">Tahun Terbit </div>
                                        <div class="comment-time mt-0">2023</div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="comment-body">
                                        <div class="comment-profileName mb-0">Penerbit </div>
                                        <div class="comment-time mt-0">Elementa Agro Lestari</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>

<script>
export default {
    data() {
        return {
            
        }
    },

    mounted() {
        document.getElementById('toggleDescription').addEventListener('click', function() {
            let expanded = this.getAttribute('aria-expanded') === 'true';
            this.textContent = expanded ? 'Ringkas Deskripsi' : 'Baca Selengkapnya';
        });
    },
}
</script>