"use client";
import ArticleFacet from "./ArticleFacet";

export default function ControllerFacet() {
  const category = process.env.NEXT_PUBLIC_CONTROLLER_CATEGORY_ID || "";
  return (
    <ArticleFacet
      category={category}
      selectionKey="controller"
      title="Controller"
      queryKey={["controllerArticles"]}
    />
  );
}
