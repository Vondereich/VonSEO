import os
import zipfile
import shutil
import re

def get_version():
    with open('vonseo.php', 'r') as f:
        content = f.read()
        match = re.search(r'Version:\s*([\d\.]+)', content)
        return match.group(1) if match else "unknown"

def remove_readonly(func, path, excinfo):
    """WinError 5 handler for shutil.rmtree."""
    import stat
    os.chmod(path, stat.S_IWRITE)
    func(path)

def main():
    version = get_version()
    plugin_name = "vonseo"
    dist_dir = "dist"
    
    # Final ZIP name with Version in ROOT
    zip_filename = f"{plugin_name}-v{version}.zip"
    zip_path = zip_filename 
    
    staging_dir = os.path.join(dist_dir, plugin_name)

    print(f"🚀 Starting build for {plugin_name} v{version}...")

    # 1. CLEANUP PHASE
    print(f"🧹 Cleaning up old ZIP files...")
    
    # Remove ALL old zip versions to keep root clean
    for f in os.listdir('.'):
        if f.startswith(f"{plugin_name}-v") and f.endswith(".zip"):
            try:
                os.remove(f)
                print(f"   Deleted: {f}")
            except Exception as e:
                print(f"   Failed to delete {f}: {e}")

    # Remove and recreate dist safely
    if os.path.exists(dist_dir):
        try:
            shutil.rmtree(dist_dir, onerror=remove_readonly)
        except Exception as e:
            print(f"⚠️  Warning: Failed to clean {dist_dir}: {e}")
    
    os.makedirs(staging_dir, exist_ok=True)

    print(f"📦 Staging files...")
    
    # 2. STAGING PHASE
    include_dirs = ['admin', 'includes', 'assets', 'languages']
    for folder in include_dirs:
        if os.path.exists(folder):
            shutil.copytree(folder, os.path.join(staging_dir, folder))
    # Copy Root Files
    include_files = ['vonseo.php', 'readme.txt', 'index.php', 'LICENSE', 'README.md', 'CHANGELOG.md', 'uninstall.php']
    for file in include_files:
        if os.path.exists(file):
            shutil.copy2(file, staging_dir)

    print(f"🗜️  Zipping {plugin_name}...")
    
    # 3. ZIP PHASE
    # Create the versioned ZIP directly from the staging folder metadata
    with zipfile.ZipFile(zip_path, 'w', zipfile.ZIP_DEFLATED) as zipf:
        # Walk the staging directory
        for root, dirs, files in os.walk(staging_dir):
            for file in files:
                file_path = os.path.join(root, file)
                # arcname starts with 'vonseowp/' inside the zip
                arcname = os.path.relpath(file_path, dist_dir)
                zipf.write(file_path, arcname)

    print(f"✅ Build successful!")
    print(f"   - Release File (Root): {os.path.abspath(zip_path)}")
    print(f"   - OTA Ready: YES (Pattern matched by Updater)")

if __name__ == "__main__":
    main()
