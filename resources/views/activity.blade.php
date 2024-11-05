<div class="main-content">
    <section class="section">
        <div class="col-lg-7 col-md-12 col-12 col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h4>Log Activity</h4>
                    <div class="card-header-action">
                        <form class="form-inline">
                            <input id="searchInput" class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
                            <!-- <button class="btn btn-primary" type="button" onclick="filterTable()">Search</button> -->
                        </form>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-striped mb-0">
                            <thead>
                                <tr>
                                    <th scope="col">No</th>
                                    <th scope="col">Username</th>
                                    <th scope="col">Activity</th>
                                    <th scope="col">Waktu</th>
                                    <th scope="col">Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="tableBody"> 
                                <?php 
                                    $no=1;
                                    foreach($erwin as $wkwk){
                                ?>                          
                                    <tr>
                                        <td><?= $no++ ?></td>
                                        <td><?= $wkwk->username?></td>
                                        <td><?= $wkwk->activity?></td>
                                        <td><?= $wkwk->timestamp?></td>
                                        <td>
                                            <a href="{{ url ('home/hapus_activity/'.$wkwk->id_activity) }} ?>" 
                                                class="btn btn-danger btn-action" 
                                                data-toggle="tooltip" 
                                                title="Delete">
                                                    <i class="fas fa-trash"></i>
                                            </a>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('searchInput');

        // Filter table function
        searchInput.addEventListener('keyup', function() {
            filterTable();
        });

        function filterTable() {
            const filter = searchInput.value.toUpperCase();
            const rows = document.querySelectorAll('#tableBody tr');

            rows.forEach(row => {
                const cells = row.getElementsByTagName('td');
                let isVisible = false;

                for (let i = 0; i < cells.length; i++) {
                    if (cells[i].textContent.toUpperCase().includes(filter)) {
                        isVisible = true;
                        break;
                    }
                }

                row.style.display = isVisible ? '' : 'none';
            });
        }

        
    });
</script>
