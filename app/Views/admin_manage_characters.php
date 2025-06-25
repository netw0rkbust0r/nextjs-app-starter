<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Admin Manage Characters - A3 Ultimate</title>
    <link href="/css/bootstrap.css" rel="stylesheet" />
    <link href="/css/bootstrap-responsive.css" rel="stylesheet" />
    <link href="/css/my_nw.css" rel="stylesheet" />
    <script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
</head>
<body>
    <?php echo view('partials/header_acp'); ?>
    <div class="container-fluid">
        <div class="row-fluid">
            <div class="span3">
                <?php // Include sidebar if exists ?>
            </div>
            <div class="span9">
                <div class="page-header" style="margin-top:0;">
                    <h1>Admin Control Panel: <small>Select Character</small></h1>
                </div>

                <form action="" method="post" class="form-inline">
                    <label for="type">Search By </label>
                    <select name="type" id="type" class="k-textbox" style="color:#000;">
                        <option value="c_id">Name</option>
                        <option value="c_sheadera">Username</option>
                    </select>
                    <input type="text" name="term" class="span9" placeholder="Enter character name" autocomplete="off" required />
                    <input type="submit" name="S1" value="Search" class="btn" />
                </form>

                <?php if (!empty($searchResults)): ?>
                    <h3>Search Results</h3>
                    <table class="table table-bordered table-striped" style="text-align:center;">
                        <thead>
                            <tr>
                                <th>Character</th>
                                <th>Username</th>
                                <th>Level</th>
                                <th>RBs</th>
                                <th>Status</th>
                                <th>Action</th>
                                <th>Account Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($searchResults as $char): ?>
                                <tr>
                                    <td style="text-align:center;">
                                        <?php if ($char['pnline'] == 1): ?>
                                            <img src="/images/status.png" title="online" alt="online" />
                                        <?php else: ?>
                                            <img src="/images/status-offline.png" title="offline" alt="offline" />
                                        <?php endif; ?>
                                        <?= esc($char['c_id']) ?>
                                    </td>
                                    <td style="text-align:center;"><?= esc($char['c_sheadera']) ?></td>
                                    <td style="text-align:center;"><?= esc($char['c_sheaderc']) ?></td>
                                    <td style="text-align:center;"><?= esc($char['rb']) ?></td>
                                    <td style="text-align:center;"><?= esc($char['c_status']) ?></td>
                                    <td style="text-align:center;">
                                        <a href="/admin/viewchar/<?= esc($char['sr_no']) ?>" title="View Character Info.">[VIEW]</a>
                                        <a href="/admin/editchar/<?= esc($char['c_id']) ?>" title="Edit Character Information">[EDIT]</a>
                                        <a href="#" title="View Inventory">[INVENTORY]</a>
                                    </td>
                                    <td style="text-align:center;">
                                        <a href="/admin/ViewAccount/<?= esc($char['c_sheadera']) ?>" title="View Account Info.">[VIEW]</a>
                                        <a href="/admin/EditAccount/<?= esc($char['c_sheadera']) ?>" title="Edit Account Information">[EDIT]</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php elseif (isset($_POST['S1'])): ?>
                    <div class="alert alert-error">
                        <h4>No results found for <?= esc($_POST['term']) ?>.</h4>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</body>
</html>
