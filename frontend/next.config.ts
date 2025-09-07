import type { NextConfig } from "next";

const isProd = process.env.NODE_ENV === "production";

const nextConfig: NextConfig = {
  output: "export",
  assetPrefix: isProd ? "./" : undefined,
  images: { unoptimized: true },
  generateBuildId: async () => "growset2",
};

export default nextConfig;
